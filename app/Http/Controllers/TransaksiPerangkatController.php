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
use App\Models\ParBagianModels;
use App\Models\SubBagianModels;
use App\Models\TransaksiModels;
use App\Models\TypeKtegoryModels;
use App\Models\DataKelompokModels;
use App\Models\TransaksiDataModel;
use Illuminate\Support\Facades\DB;
use App\Models\DataManajemenModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class TransaksiPerangkatController extends Controller
{
    public function index()
    {
        return \view('transaksi/perangkat.index');
    }

    public function getTrsPerangkat()
    {
        $trsPerangkat = TransaksiDataModel::with(['trsHasData','trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic'])
        ->orderBy('trs_id', 'desc')->where('trs_jenis_id',1)->get();

        // dd($trsPerangkat);
        return DataTables::of($trsPerangkat)
            // ->addColumn('actions', 'transaksi/perangkat.actions')
            ->addColumn('details_url', function(TransaksiDataModel $dp) {
               if ($dp->trsHasData) {
                   $btn = '<button data-url="'.route("detail_trs",['id'=>$dp->trsHasData->data_manajemen_id,'id_trs'=>$dp->trs_id ]).' " data-toggle="tooltip" data-placement="top" title="Detail" class="btn btn-success mr-1 btn-sm cek">Detail</button>';
                    $btn = $btn.'<a href="'.route("edit_trs",['id'=>$dp->trs_id]).'" class="edit btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit">Edit</a>';
                   return $btn;
                }
                return '';
            })
            ->addColumn('perangkat', function (TransaksiDataModel $dp) {
                if ($dp->trsHasData) {
                    return $dp->trsHasData->data_manajemen_name;
                }
                return '';
            })
            ->addColumn('pegawai', function (TransaksiDataModel $dt) {
                if ($dt->trsHasPegawai) {
                    return $dt->trsHasPegawai->pegawai_name;
                }
                return '';
            })
            ->addColumn('sub', function (TransaksiDataModel $dk) {
                if ($dk->trsHasSubBagian) {
                    return $dk->trsHasSubBagian->sub_bagian_nama;
                }
                return '';
            })
            ->addColumn('bagian', function (TransaksiDataModel $dg) {
                if ($dg->trsHasBagian) {
                    return $dg->trsHasBagian->nama_bagian;
                }
                return '';
            })
            ->addColumn('status', function (TransaksiDataModel $dp) {
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
    public function detail($id, $id_trs)
    {

        $DataPerangkat = TransaksiDataModel::with(['trsHasData' => function($q) use ($id){
            $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi', 'manajemenHasSupplier']);
            $q->where('data_manajemen_id', $id);
        }, 'trsHasGedung', 'trsHasRuangan', 'trsHasKondisi'])
        ->where('trs_id', $id_trs)
        ->get();
        return DataTables::of($DataPerangkat)
            ->addColumn('merk', function (TransaksiDataModel $dp) {
                if ($dp->trsHasData->manajemenHasMerk) {
                    return $dp->trsHasData->manajemenHasMerk->nama_data_merk;
                }
                return '';
            })
            ->addColumn('type', function (TransaksiDataModel $dt) {
                if ($dt->trsHasData->manajemenHasType) {
                    return $dt->trsHasData->manajemenHasType->nama_data_type;
                }
                return '';
            })
            ->addColumn('kondisi', function (TransaksiDataModel $dk) {
                if ($dk->trsHasKondisi) {
                    return $dk->trsHasKondisi->nama_data_kondisi;
                }
                return '';
            })
            ->addColumn('gedung', function (TransaksiDataModel $dg) {
                if ($dg->trsHasGedung) {
                    return $dg->trsHasGedung->nama_data_gedung;
                }
                return '';
            })
            ->addColumn('ruangan', function (TransaksiDataModel $dr) {
                if ($dr->trsHasRuangan) {
                    return $dr->trsHasRuangan->nama_data_ruangan;
                }
                return '';
            })
            ->addColumn('supplier', function (TransaksiDataModel $ds) {
                if ($ds->trsHasData->manajemenHasSupplier) {
                    return $ds->trsHasData->manajemenHasSupplier->supplier_name;
                }
                return '';
            })
            ->addColumn('kelompok', function (TransaksiDataModel $ds) {
                if ($ds->trsHasKelompok) {
                    return $ds->trsHasKelompok->nama_data_kelompok;
                }
                return '';
            })
            ->rawColumns(['merk', 'type', 'kondisi', 'gedung', 'ruangan', 'supplier', 'kelompok'])
            ->addIndexColumn()
            ->make(true);
        return Datatables::of($DataPerangkat)->make(true);
        // dd($DataPerangkat);
    }
    public function tambah(Request $request)
    {
        $dataStok = StokModels::where('data_status_id',1)->where('data_jumlah', '>', 0)->where('data_kategory_id',3)->get();

        $dataPegawai = PegawaiModels::get();
        $gedung = GedungModels::get();
        $ruangan = RuanganModels::get();
        $countTrs = TransaksiModels::all()->count()+1;
        $getKodeTrs = 'TRS-PRK-' . $countTrs .'';

        // dd($dataStok);
        return \view('transaksi/perangkat.tambah', \compact('ruangan' ,'gedung' ,'dataPegawai','dataStok', 'getKodeTrs'));
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
    public function getperangkat(Request $request)
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

    public function save(Request $request){
        // dd($request->all());
        $request->validate([
            'keterangan' => 'required',
            'perangkat' => 'required',
            'pegawai' => 'required',
            'gedung' => 'required',
            'ruangan' => 'required',

        ],
        [
            'keterangan.required' => 'Keterangan tidak boleh kosong!',
            'perangkat.required' => ' Perangkat tidak boleh kosong!',
            'pegawai.required' => 'Pegawai tidak boleh kosong!',
            'gedung.required' => 'Gedung tidak boleh kosong!',
            'ruangan.required' => 'Ruangan tidak boleh kosong!',
        ]);

        $save = [

            'trs_kode'=> $request->id_trs_prkt,
            'trs_data_stok_id'=> $request->perangkat,
            'trs_gedung_id'=> $request->gedung,
            'trs_ruang_id'=> $request->ruangan,
            'trs_pic_id'=> Auth::user()->id,
            'trs_date'=> Carbon::today(),
            'trs_keterangan'=> $request->keterangan,
            'trs_pegawai_id'=> $request->pegawai,
            'trs_status_id' => 1,
        ];

        $stok = StokModels::find($request->perangkat);
        $stok->decrement('data_jumlah', 1);

        $stok = StokModels::find($request->perangkat);
        $stok->increment('data_dipakai', 1);

        $saveTrsPerangkat =TransaksiModels::create($save);

        $cek = Log::channel('database')->info($saveTrsPerangkat);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('tambah data transaksi perangkat' ,json_encode($query));

        Alert::success('Success', 'Data berhasil di Simpan');
        return redirect('transaksi_data/perangkat_trans');
    }

    public function edit($id){

        $trsPerangkat = TransaksiDataModel::with(['trsHasData'=> function ($q){
            $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi','manajemenHasSupplier']);
        },'trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic'])
        ->orderBy('trs_id', 'asc')->where('trs_jenis_id',1)->where('trs_id', $id)->first();
        //  dd($trsPerangkat);
        $dataPerangkat = DataManajemenModels::where('data_manajemen_kode_id',1)->get();

        $dataPegawai = PegawaiModels::get();
        $kelompok = DataKelompokModels::get();
        $gedung = GedungModels::get();
        $ruangan = RuanganModels::get();

        return \view('transaksi/perangkat.edit', \compact('ruangan','gedung','trsPerangkat', 'dataPegawai', 'kelompok', 'dataPerangkat'));
    }

    public function update(Request $request , $id){

        $request->validate([
            'keterangan' => 'required',
            // 'perangkat' => 'required',
            'pegawai' => 'required',
            'bagian' => 'required',
            'subBagian' => 'required',
            'kelompok' => 'required',
            'gedung' => 'required',
            'ruangan' => 'required',

        ],
        [
            'keterangan.required' => 'Keterangan tidak boleh kosong!',
            // 'perangkat.required' => ' Perangkat tidak boleh kosong!',
            'pegawai.required' => 'Pegawai tidak boleh kosong!',
            'bagian.required' => 'Bagian tidak boleh kosong!',
            'subBagian.required' => 'Sub Bagian tidak boleh kosong!',
            'kelompok.required' => 'Kelompok tidak boleh kosong!',
            'gedung.required' => 'Gedung tidak boleh kosong!',
            'ruangan.required' => 'Ruangan tidak boleh kosong!',
        ]);

        $save = [
            'trs_name'=> $request->keterangan,
            // 'trs_data_id'=> $request->perangkat,
            'trs_pegawai_id'=> $request->pegawai,
            'trs_bagian_id'=> $request->bagian_,
            'trs_sub_bagian_id'=> $request->subBagian_,
            'trs_kelompok_id'=> $request->kelompok,
            'trs_ruangan_id'=> $request->ruangan,
            'trs_gedung_id'=> $request->gedung,
            'trs_pic_id'=> Auth::user()->id,
            'trs_date'=> Carbon::today(),
        ];

        $updatedata = TransaksiDataModel::where('trs_id', $id)->update($save);

        $cek = \Log::channel('database')->info($updatedata);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('update data transaksi perangkat' ,json_encode($query));

        Alert::success('Success', 'Data berhasil di Update');
        return redirect('transaksi_data/perangkat_trans');
    }
}
