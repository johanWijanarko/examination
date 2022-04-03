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
use App\Models\DetailTransaksi;
use App\Models\SubBagianModels;
use App\Models\TransaksiModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class TransaksiAlatKantor extends Controller
{
    public function index()
    {
        // $trsDetail = DetailTransaksi::with(['trsHasStok2', 'trsHasPegawai2'=> function($q){
        //     $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
        // }, 'mainTransaksi'])
        // ->whereHas('trsHasStok2', function($q){
        //     $q->where('data_kategory_id',4);
        // })
        // ->whereHas('mainTransaksi', function($q){
        //     $q->orderBy('trs_id', 'asc')->where('trs_status_id',1);
        // })
        // ->get();

        // dd($trsDetail);
        return \view('transaksi/peralatan.index');
    }

    public function getTrsAtk()
    {
        $trsDetail = DetailTransaksi::with(['trsHasStok2', 'trsHasPegawai2'=> function($q){
            $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
        }, 'mainTransaksi'])
        ->whereHas('trsHasStok2', function($q){
            $q->where('data_kategory_id',4);
        })
        ->whereHas('mainTransaksi', function($q){
            $q->orderBy('trs_id', 'asc')->where('trs_status_id',1);
        })
        ->get();

        // dd($trsPerangkat);
        return DataTables::of($trsDetail)
            // ->addColumn('actions', 'transaksi/perangkat.actions')
            ->addColumn('details_url', function(DetailTransaksi $dp) {
               if ($dp->mainTransaksi->trs_id) {
                $btn ='<a href="'.route("edit_trs_atk",['id'=>$dp->mainTransaksi->trs_id]).'" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-sm btn-warning rounded-circle " ><i class="fas fa-edit"></i></i></a>';
                $btn =$btn.'<a data-toggle="modal" id="smallButton"  data-target="#smallModal" data-attr="'.route("detail_trs_atk",['id'=>$dp->mainTransaksi->trs_id]).'" data-placement="top" title="Edit" class="btn btn-sm btn-success rounded-circle " ><i class="fas fa-eye"></i></a>';
                return $btn;
                }
                return '';
            })
            ->addColumn('perangkat', function (DetailTransaksi $dp) {
                if ($dp->trsHasStok2) {
                    return $dp->trsHasStok2->data_name;
                }
                return '';
            })
            ->addColumn('pegawai', function (DetailTransaksi $dt) {
                if ($dt->trsHasPegawai2) {
                    return $dt->trsHasPegawai2->pegawai_name;
                }
                return '';
            })
            ->addColumn('bagian', function (DetailTransaksi $dk) {
                if ($dk->trsHasPegawai2) {
                    if ($dk->trsHasPegawai2->pegawaiHasBagian) {
                        return $dk->trsHasPegawai2->pegawaiHasBagian->nama_bagian;
                    }
                }

                return '';
            })
            ->addColumn('sub', function (DetailTransaksi $dg) {
                if ($dg->trsHasPegawai2) {
                    if ($dg->trsHasPegawai2->pegawaiHasSubBagian) {
                        return $dg->trsHasPegawai2->pegawaiHasSubBagian->sub_bagian_nama;
                    }
                }
                return '';
            })
            ->addColumn('status', function (DetailTransaksi $dp) {
                $status = [
                    '1' => 'Dipakai',
                    '2' => 'Dipinjam',
                    '3' => 'Sedang diperbaiki',
                    '4' => 'Dikembalikan',
                    '5' => 'Dimutasi',
                ];

                if ($dp->mainTransaksi->trs_status_id) {
                    return $status[$dp->mainTransaksi->trs_status_id];
                }
                return '';
            })
            ->addColumn('keterangan', function (DetailTransaksi $dp) {
                if ($dp->mainTransaksi) {
                    return $dp->mainTransaksi->trs_keterangan;
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

        return view('transaksi/peralatan.detail',compact('trsPerangkat'));
    }

    public function tambah(Request $request)
    {
        $dataStok = StokModels::where('data_status_id',1)->where('data_jumlah', '>', 0)->where('data_kategory_id',4)->get();

        $dataPegawai = PegawaiModels::get();
        $gedung = GedungModels::get();
        $ruangan = RuanganModels::get();
        $countTrs = TransaksiModels::all()->count()+1;
        $getKodeTrs = 'TRS-ATK-' . $countTrs .'';

        return \view('transaksi/peralatan.tambah', \compact('ruangan' ,'gedung' ,'dataPegawai','dataStok', 'getKodeTrs'));
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
    public function gatAtk(Request $request)
    {
        $dataStok =StokModels::where('data_stok_id', $request->get('id'))->where('data_status_id',1)->where('data_kategory_id', 4)->first();

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
        $tgl = date("Y-m-d", strtotime($request->tgl) );

        $request->validate([
            'keterangan' => 'required',
            'tgl' => 'required',

        ],
        [
            'keterangan.required' => 'Keterangan tidak boleh kosong!',
            'tgl.required' => ' Tanggal tidak boleh kosong!',
        ]);

        $save = [
            'trs_kode'=> $request->id_trs_prkt,
            'trs_keterangan'=> $request->keterangan,
            'trs_date'=> $tgl,
        ];
        $trsAtk =TransaksiModels::create($save);
        // dd($trsAtk->trs_id);
        $trsId = $trsAtk->trs_id;
        $data2 = array();
        if ($request->perangkat) {
            foreach ($request->perangkat as $key => $data) {
                $data2[$key]['trs_id'] = $trsId;
                $data2[$key]['trs_detail_pegawai_id'] = $request->pegawai[$key];
                $data2[$key]['trs_detail_data_stok_id'] = $request->perangkat[$key];
                $data2[$key]['trs_detail_gedung_id'] = $request->gedung[$key];
                $data2[$key]['trs_detail_ruangan'] = $request->ruangan[$key];
                $data2[$key]['trs_detail_jumlah'] = $request->jml[$key];

                $stok = StokModels::whereIn('data_stok_id',[$request->perangkat[$key]]);
                $stok->decrement('data_jumlah', $request->jml[$key]);

                $stok = StokModels::whereIn('data_stok_id',[$request->perangkat[$key]]);
                $stok->increment('data_dipakai', $request->jml[$key]);
            }

            $save_detail = DB::table('trs_detail')->insert($data2);
        }

        $cek = Log::channel('database')->info($save_detail);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('tambah data transaksi atk' ,json_encode($query));

        Alert::success('Success', 'Data berhasil di Simpan');
        return redirect('transaksi_data/p_kantor_trans');
    }

    public function edit($id){

        // $trsDetail = DetailTransaksi::with(['trsHasStok2', 'trsHasPegawai2'=> function($q){
        //     $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
        // }, 'mainTransaksi'])
        // ->whereHas('trsHasStok2', function($q){
        //     $q->where('data_kategory_id',4);
        // })
        // ->whereHas('mainTransaksi', function($q) use ($id){
        //     $q->orderBy('trs_id', 'asc')->where('trs_status_id',1);
        //     $q->where('trs_id', $id);
        // })->first();

        $detail = TransaksiModels::with(['trsDetail'=> function($q){
            $q->with(['trsHasPegawai2' => function($q){
                $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
            }]);
        }])->where('trs_id', $id)->first();
        // dd($detail);
        $dataStok = StokModels::where('data_status_id',1)->where('data_jumlah', '>', 0)->where('data_kategory_id',4)->get();
        $dataPegawai = PegawaiModels::get();
        $gedung = GedungModels::get();
        $ruangan = RuanganModels::get();

        return \view('transaksi/peralatan.edit', \compact('ruangan','gedung','detail', 'dataPegawai','dataStok'));
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
        return redirect('transaksi_data/p_kantor_trans');
    }
}
