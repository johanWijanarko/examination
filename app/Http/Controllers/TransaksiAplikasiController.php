<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\StokModels;
use App\Models\GedungModels;
use Illuminate\Http\Request;
use App\Models\KondisiModels;
use App\Models\PegawaiModels;
use App\Models\RuanganModels;
use App\Models\DataMerkModels;
use App\Models\SupplierModels;
use App\Models\SubBagianModels;
use App\Models\TransaksiModels;
// use App\Models\TransaksiDataModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class TransaksiAplikasiController extends Controller
{
    public function index()
    {
        return \view('transaksi/aplikasi.index');
    }

    public function getTrsaplikasi()
    {
        $trsPerangkat = TransaksiModels::with(['trsHasStok'=> function ($q){
            $q->with(['stokHasMerk','stokHasType','stokHasKondisi','stokHasSupplier']);
            $q->where('data_kategory_id',13);
        },'trsHasPegawai'=> function ($q){
            $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
        },'trsHasGedung','trsHasRuangan','trsHasPic'])
        ->whereHas('trsHasStok', function ($q){
            $q->where('data_kategory_id',13);
        })
        ->orderBy('trs_id', 'asc')->where('trs_status_id',1)->get();

        // dd($trsPerangkat);
        return DataTables::of($trsPerangkat)
            // ->addColumn('actions', 'transaksi/perangkat.actions')
            ->addColumn('details_url', function(TransaksiModels $dp) {
               if ($dp->trs_id) {
                $btn ='<a href="'.route("edit_trs_aplikasi",['id'=>$dp->trs_id]).'" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-sm btn-warning rounded-circle " ><i class="fas fa-edit"></i></i></a>';
                $btn =$btn.'<a data-toggle="modal" id="smallButton"  data-target="#smallModal" data-attr="'.route("detail_trs_aplikasi",['id'=>$dp->trs_id]).'" data-placement="top" title="Edit" class="btn btn-sm btn-success rounded-circle " ><i class="fas fa-eye"></i></a>';
                return $btn;
                }
                return '';
            })
            ->addColumn('perangkat', function (TransaksiModels $dp) {
                if ($dp->trsHasStok) {
                    return $dp->trsHasStok->data_name;
                }
                return '';
            })
            ->addColumn('pegawai', function (TransaksiModels $dt) {
                if ($dt->trsHasPegawai) {
                    return $dt->trsHasPegawai->pegawai_name;
                }
                return '';
            })
            ->addColumn('bagian', function (TransaksiModels $dk) {
                if ($dk->trsHasPegawai->pegawaiHasBagian) {
                    return $dk->trsHasPegawai->pegawaiHasBagian->nama_bagian;
                }
                return '';
            })
            ->addColumn('sub', function (TransaksiModels $dg) {
                if ($dg->trsHasPegawai->pegawaiHasSubBagian) {
                    return $dg->trsHasPegawai->pegawaiHasSubBagian->sub_bagian_nama;
                }
                return '';
            })
            ->addColumn('status', function (TransaksiModels $dp) {
                $status = [
                    '1' => 'Dipakai',
                    '2' => 'Dipinjam',
                    '3' => 'Sedang diperbaiki',
                    '4' => 'Dikembalikan',
                    '5' => 'Dimutasi',
                ];

                if ($dp->trs_status_id) {
                    return $status[$dp->trs_status_id];
                }
                return '';
            })
            ->rawColumns(['actions', 'perangkat', 'pegawai', 'sub', 'bagian', 'details_url', 'status'])
            ->addIndexColumn()
            ->make(true);

    }
 

    public function detail($id){
        // $getData = DataManajemenModels::find($id);
        $trsPerangkat = TransaksiModels::with(['trsHasStok'=> function ($q){
            $q->with(['stokHasMerk','stokHasType','stokHasKondisi','stokHasSupplier']);
            $q->where('data_kategory_id',13);
        },'trsHasPegawai'=> function ($q){
            $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
        },'trsHasGedung','trsHasRuangan','trsHasPic'])
        ->orderBy('trs_id', 'asc')->where('trs_status_id',1)->where('trs_id',$id)->first();
        // dd($trsPerangkat);

        return view('transaksi/aplikasi.detail',compact('trsPerangkat'));
    }

    public function tambah(Request $request)
    {
        $dataStok = StokModels::where('data_status_id',1)->where('data_jumlah', '>', 0)->where('data_kategory_id',13)->get();

        $dataPegawai = PegawaiModels::get();
        $gedung = GedungModels::get();
        $ruangan = RuanganModels::get();
        $countTrs = TransaksiModels::all()->count()+1;
        $getKodeTrs = 'TRS-APL-' . $countTrs .'';

        return \view('transaksi/aplikasi.tambah', \compact('ruangan' ,'gedung' ,'dataPegawai','dataStok', 'getKodeTrs'));
    }

    public function getSubBagian(Request $request)
    {
        $subBagian = SubBagianModels::where('sub_bagian_bagian_id',$request->id)->get()
        ->map(function ($p){
            return [
                'id' => $p->sub_bagian_id,
                'nama' => $p->sub_bagian_nama,
            ];
        });
        return response()->json($subBagian);
    }
    public function gatAplikasi(Request $request)
    {
        $dataStok =StokModels::where('data_stok_id', $request->get('id'))->where('data_status_id',1)->first();

        $getMerk = DataMerkModels::select('nama_data_merk')->where('data_merk_id', $dataStok->data_merk_id)->first();
        $kondisi = KondisiModels::select('nama_data_kondisi','data_kondisi_id')->where('data_kondisi_id', $dataStok->data_kondisi_id)->first();
        $supplier = SupplierModels::select('supplier_name')->where('supplier_id', $dataStok->data_supplier_id)->first();

         return response()->json([
            'getMerk' => $getMerk,
            'kondisi' => $kondisi,
            'supplier' => $supplier,
            'dataStok' => $dataStok
        ]);

    }

    public function getPegawai(Request $request){
        $detailPegawai = PegawaiModels::with(['pegawaiHasBagian','pegawaiHasSubBagian'])->where('pegawai_id', $request->id)->first();
        return response()->json($detailPegawai);
    }

    public function save(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'keterangan' => 'required',
            'aplikasi' => 'required',
            'pegawai' => 'required',
            'gedung' => 'required',
            'ruangan' => 'required',

        ],
        [
            'keterangan.required' => 'Keterangan tidak boleh kosong!',
            'aplikasi.required' => ' aplikasi tidak boleh kosong!',
            'pegawai.required' => 'Pegawai tidak boleh kosong!',
            'gedung.required' => 'Gedung tidak boleh kosong!',
            'ruangan.required' => 'Ruangan tidak boleh kosong!',
        ]);

        $save = [

            'trs_kode'=> $request->id_trs_prkt,
            'trs_data_stok_id'=> $request->aplikasi,
            'trs_gedung_id'=> $request->gedung,
            'trs_ruang_id'=> $request->ruangan,
            'trs_pic_id'=> Auth::user()->id,
            'trs_date'=> Carbon::today(),
            'trs_keterangan'=> $request->keterangan,
            'trs_pegawai_id'=> $request->pegawai,
        ];

        // $stok = StokModels::find($request->perangkat);
        // $stok->decrement('data_jumlah', 1);

        // $stok = StokModels::find($request->perangkat);
        // $stok->increment('data_dipakai', 1);

        $saveTrsPerangkat =TransaksiModels::create($save);

        $cek = Log::channel('database')->info($saveTrsPerangkat);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('tambah data transaksi perangkat' ,json_encode($query));

        Alert::success('Success', 'Data berhasil di Simpan');
        return redirect('transaksi_data/aplikasi_trans');
    }

    public function edit($id){

        $trsPerangkat = TransaksiModels::with(['trsHasStok'=> function ($q){
            $q->with(['stokHasMerk','stokHasType','stokHasKondisi','stokHasSupplier']);
        },'trsHasPegawai'=> function ($q){
            $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
        },'trsHasGedung','trsHasRuangan','trsHasPic'])
        ->orderBy('trs_id', 'asc')->where('trs_status_id',1)->where('trs_id', $id)
        ->whereHas('trsHasStok', function ($q){
            $q->where('data_kategory_id',13);
        })->first();

        $dataStok = StokModels::where('data_status_id',1)->where('data_jumlah', '>', 0)->where('data_kategory_id',3)->get();
        $dataPegawai = PegawaiModels::get();
        $gedung = GedungModels::get();
        $ruangan = RuanganModels::get();

        return \view('transaksi/aplikasi.edit', \compact('ruangan','gedung','trsPerangkat', 'dataPegawai','dataStok'));
    }

    public function update(Request $request , $id){
        // dd($request->all());
        $request->validate([
            'keterangan' => 'required',
            'pegawai' => 'required',
            'gedung' => 'required',
            'ruangan' => 'required',

        ],
        [
            'keterangan.required' => 'Keterangan tidak boleh kosong!',
            'pegawai.required' => 'Pegawai tidak boleh kosong!',
            'gedung.required' => 'Gedung tidak boleh kosong!',
            'ruangan.required' => 'Ruangan tidak boleh kosong!',
        ]);

        $save = [
            'trs_gedung_id'=> $request->gedung,
            'trs_ruang_id'=> $request->ruangan,
            'trs_pic_id'=> Auth::user()->id,
            'trs_date'=> Carbon::today(),
            'trs_keterangan'=> $request->keterangan,
            'trs_pegawai_id'=> $request->pegawai,
        ];

        $updatedata = TransaksiModels::where('trs_id', $id)->update($save);

        $cek = Log::channel('database')->info($updatedata);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('update data transaksi perangkat' ,json_encode($query));

        Alert::success('Success', 'Data berhasil di Update');
        return redirect('transaksi_data/aplikasi_trans');
    }
}
