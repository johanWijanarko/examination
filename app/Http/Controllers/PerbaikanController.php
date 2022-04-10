<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\StokModels;
use Illuminate\Http\Request;
use App\Models\PegawaiModels;
use App\Models\DetailTransaksi;
use App\Models\PerbaikanModels;
use App\Models\TypeKtegoryModels;
use App\Models\TransaksiDataModel;
use Illuminate\Support\Facades\DB;
use App\Models\DataManajemenModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class PerbaikanController extends Controller
{
    public function index(){
        return \view('transaksi.perbaikan/index');
    }

    public function getDataPerbaikan(Request $request){
        $getperbaikan = PerbaikanModels::with(['perbaikanHasObjek', 'perbaikanHasPegawai'])->get();
        // dd($getperbaikan);
        return DataTables::of($getperbaikan)
            ->addColumn('details_url', function(PerbaikanModels $dp) {
                if ($dp) {
                    // $btn = '<button data-url="'.route("detailPerbaikan",['id'=>$dp->perbaikan_id, 'trs_id'=>$dp->perbaikan_trs_id]).'" data-toggle="tooltip" data-placement="top" title="Detail" class="btn btn-success mr-1 btn-sm cek">Detail</button>';
                    $btn = '<a href="'.route("editPerbaikan",['id'=>$dp->perbaikan_id, 'trs_id'=>$dp->perbaikan_trs_id]).'" class="edit btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit">Edit</a>';
                   return $btn;
                }
                return '';
            })
            ->addColumn('dataPerbaikan', function (PerbaikanModels $dp) {
                if ($dp->PerbaikanHasType) {
                    return $dp->PerbaikanHasType->nama_data_type;
                }
                return '';
            })
            ->addColumn('ObjekMutasi', function (PerbaikanModels $dp) {
                if ($dp->perbaikanHasObjek) {
                    return $dp->perbaikanHasObjek->data_name;
                }
                return '';
            })
            ->addColumn('pegawai', function (PerbaikanModels $dk) {
                if ($dk->perbaikanHasPegawai) {
                    return $dk->perbaikanHasPegawai->pegawai_name;
                }
                return '';
            })
            ->addColumn('tgl', function (PerbaikanModels $dk) {
                if ($dk->perbaikan_tgl_in) {
                    return date('d-m-Y', strtotime($dk->perbaikan_tgl_in));
                }
                return '';
            })
            ->addColumn('estimasi', function (PerbaikanModels $dk) {
                if ($dk->perbaikan_estimasi) {
                    return date('d-m-Y', strtotime($dk->perbaikan_estimasi));
                }
                return '';
            })
            ->addColumn('status', function (PerbaikanModels $dp) {
                 $statusPerbaikan = [
                    '3' => 'Sedang diperbaiki',
                    '6' => 'Selesai diperbaiki',
                    '7' => 'Tidak dapat diperbaiki',

                ];

                if ($dp->perbaikan_status) {
                    return $statusPerbaikan[$dp->perbaikan_status];
                }
                return '';
            })
            ->rawColumns(['data', 'ObjekMutasi','details_url', 'pegawai','status'])
            ->addIndexColumn()
            ->make(true);
    }

    public function tambah()
    {
        $type = TypeKtegoryModels::get();
        $dataPegawai = PegawaiModels::get();
        return \view('transaksi.perbaikan/tambah', \compact('dataPegawai','type'));
    }

    public function getObejkPerbaikan(Request $request)
    {
        $getObejkPerbaikan = StokModels::where('data_kategory_id', $request->id)
        ->orderBy('data_stok_id', 'desc')
        ->pluck('data_name', 'data_stok_id');

        return response()->json($getObejkPerbaikan);
    }

     public function getPegawiPerbaikan(Request $request)
    {
        $getPegawiMutasi = DetailTransaksi ::with('trsHasPegawai2')
        ->where('trs_detail_data_stok_id', $request->id)
        ->orderBy('trs_detail_id', 'asc')->get()
        // ->map('trsHasPegawai.pegawai_name', 'trsHasPegawai.pegawai_id');
        ->map(function ($p){
            return [
                'id' => $p->trs_detail_id,
                'id_peg' => $p->trsHasPegawai2->pegawai_id,
                'pegawe_name' => $p->trsHasPegawai2->pegawai_name,
            ];
        });
            // dd($getPegawiPerbaikan);
        return response()->json($getPegawiMutasi);
    }

    public function getRekapPerbaikan(Request $request)
    {
        $data = explode(":", $request->id);
        $pegawai_id = (int)$data[0];
        $trs_id = (int)$data[1];

        $getRekapPerbaikan = TransaksiDataModel ::with(['trsHasBagian', 'trsHasSubBagian', 'trsHasGedung','trsHasRuangan', 'trsHasData'=> function ($q){
            $q->with('manajemenHasKondisi');
        }])
        ->where('trs_id', $trs_id)
        ->where('trs_pegawai_id', $pegawai_id)
        ->first();

       return response()->json($getRekapPerbaikan);

    }

    public function save(Request $request)
    {
        // dd($request->all());
        $data = explode(":", $request->pegawai);
        $pegawai_id = (int)$data[0];
        $trs_id = (int)$data[1];

        $request->validate([
            'data_perbaikan' => 'required',
            'obj' => 'required',
            'tglPerbikan' => 'required',
            'estimasi' => 'required',
            'ketPerbaikan' => 'required',
        ],
        [
            'data_perbaikan.required' => 'Data Perbaikan tidak boleh kosong!',
            'obj.required' => 'Objek Perbaikan tidak boleh kosong!',
            'tglPerbikan.required' => 'Tanggal Perbaikan tidak boleh kosong!',
            'estimasi.required' => 'Estimasi tidak boleh kosong!',
            'ketPerbaikan.required' => 'Keterangan tidak boleh kosong!',
        ]);

        $save = [
            'perbaikan_data_id'=> $request->data_perbaikan,
            'perbaikan_objek_id'=> $request->obj,
            'perbaikan_pegawai_id'=> $pegawai_id,
            'perbaikan_trs_id'=> $trs_id,
            'perbaikan_tgl_in'=> $request->tglPerbikan,
            'perbaikan_estimasi'=>$request->estimasi,
            'perbaikan_keterangan'=>$request->ketPerbaikan,
            'perbaikan_pic_id'=> Auth::user()->id,
            'perbaikan_tgl'=> Carbon::today(),
            'perbaikan_status' => 3
        ];

        $savePerbaikan = PerbaikanModels::insert($save);

        $updateTrs =DetailTransaksi::where('trs_detail_id', $trs_id)->update(['trs_detail_status'=>3]);

        $cek = Log::channel('database')->info($savePerbaikan);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('tambah transaksi perbaikan' ,json_encode($query));

        Alert::success('Success', 'Data berhasil di Simpan');
        return redirect('transaksi_data/perbaikan');
    }

    public function detail(Request $request, $id, $trs_id)
    {
        $datadetail = PerbaikanModels::orderBy('perbaikan_id', 'desc')->with(['perbaikanHasObjek' => function($q){
            $q->with('manajemenHasMerk');
            $q->with('manajemenHasType');
            $q->with('manajemenHasSupplier');
        }, 'perbaikanHasTrs'=> function($q) use ($trs_id){
            $q->with('trsHasGedung');
            $q->with('trsHasRuangan');
            $q->with('trsHasKelompok');
            $q->where('trs_id', $trs_id);
        }])
        ->where('perbaikan_id', $id)->get();

        return DataTables::of($datadetail)
            ->addColumn('merk', function (PerbaikanModels $dt) {
                if ($dt->perbaikanHasObjek->manajemenHasMerk) {
                    return $dt->perbaikanHasObjek->manajemenHasMerk->nama_data_merk;
                }

                return '';
            })
            ->addColumn('type', function (PerbaikanModels $dk) {
                if ($dk->perbaikanHasObjek->manajemenHasType) {
                    return $dk->perbaikanHasObjek->manajemenHasType->nama_data_type;
                }
                return '';
            })
            ->addColumn('gedung', function (PerbaikanModels $dg) {
                if ($dg->perbaikanHasTrs->trsHasGedung) {
                    return $dg->perbaikanHasTrs->trsHasGedung->nama_data_gedung;
                }
                return '';
            })
            ->addColumn('ruangan', function (PerbaikanModels $dg) {
                if ($dg->perbaikanHasTrs->trsHasRuangan) {
                    return $dg->perbaikanHasTrs->trsHasRuangan->nama_data_ruangan;
                }
                return '';
            })
            ->addColumn('supplier', function (PerbaikanModels $dg) {
                if ($dg->perbaikanHasObjek->manajemenHasSupplier) {
                    return $dg->perbaikanHasObjek->manajemenHasSupplier->supplier_name;
                }
                return '';
            })
            ->addColumn('kelompok', function (PerbaikanModels $dg) {
                if ($dg->perbaikanHasTrs->trsHasKelompok) {
                    return $dg->perbaikanHasTrs->trsHasKelompok->nama_data_kelompok;
                }
                return '';
                return '';
            })

            ->rawColumns(['details_url'])
            ->addIndexColumn()
            ->make(true);
        // dd($datadetail);
    }

    public function edit(Request $request, $id, $trs_id)
    {

        $type = TypeKtegoryModels::get();
        $dataPerbaikan = PerbaikanModels::orderBy('perbaikan_id', 'desc')->with(['perbaikanHasObjek', 'perbaikanHasPegawai','perbaikanHasTrs'])->where('perbaikan_id', $id)->first();

        $opjekPerbaikan = StokModels::where('data_kategory_id', $dataPerbaikan->perbaikan_data_id)->get();

        $dataPegawai = DetailTransaksi::with(['trsHasPegawai2'])->where('trs_detail_data_stok_id',$dataPerbaikan->perbaikan_objek_id)->get();
        // dd($dataPerbaikan);
        return \view('transaksi/perbaikan.edit', \compact('dataPegawai', 'dataPerbaikan', 'opjekPerbaikan', 'type'));

    }

    public function update(Request $request,$id)
    {
        // dd($request->all());
//
        $request->validate([
            'data_perbaikan' => 'required',
            'obj' => 'required',
            'tglPerbikan' => 'required',
            'estimasi' => 'required',
            'ketPerbaikan' => 'required',
        ],
        [
            'data_perbaikan.required' => 'Data Perbaikan tidak boleh kosong!',
            'obj.required' => 'Objek Perbaikan tidak boleh kosong!',
            'tglPerbikan.required' => 'Tanggal Perbaikan tidak boleh kosong!',
            'estimasi.required' => 'Estimasi tidak boleh kosong!',
            'ketPerbaikan.required' => 'Keterangan tidak boleh kosong!',
        ]);


            $save = [
                'perbaikan_data_id'=> $request->data_perbaikan,
                'perbaikan_objek_id'=> $request->obj,
                'perbaikan_pegawai_id'=> $request->pegawai,
                'perbaikan_tgl_in'=> $request->tglPerbikan,
                'perbaikan_estimasi'=>$request->estimasi,
                'perbaikan_keterangan'=>$request->ketPerbaikan,
                'perbaikan_pic_id'=> Auth::user()->id,
                'perbaikan_tgl'=> Carbon::today(),
                'perbaikan_status' =>$request->status,
            ];
            $perbaikan =PerbaikanModels::where('perbaikan_id', $id)->update($save);

            $UPDATE=['trs_detail_status'=>$request->status];

            $perbaikan =DetailTransaksi::where('trs_detail_id', $request->trs_detail_id)->update($UPDATE);

        $cek = \Log::channel('database')->info($perbaikan);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('update transaksi perbaikan' ,json_encode($query));

        Alert::success('Success', 'Data berhasil di Simpan');
        return redirect('transaksi_data/perbaikan');
    }
}
