<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\PegawaiModels;
use App\Models\PerbaikanModels;
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
                    $btn = '<button data-url="'.route("detailPerbaikan",['id'=>$dp->perbaikan_id, 'trs_id'=>$dp->perbaikan_trs_id]).'" data-toggle="tooltip" data-placement="top" title="Detail" class="btn btn-success mr-1 btn-sm cek">Detail</button>';
                    $btn = $btn.'<a href="'.route("editPerbaikan",['id'=>$dp->perbaikan_id, 'trs_id'=>$dp->perbaikan_trs_id]).'" class="edit btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit">Edit</a>';
                   return $btn;
                }
                return '';
            })
            ->addColumn('dataPerbaikan', function (PerbaikanModels $dp) {
                $jenisPerbaikan = [ 
                    '1' => 'Perangkat',
                    '2' => 'Aplikasi',
                    '3' => 'Peralatan Kantor',
                    '4' => 'Inventaris'
                ];
                
                if ($dp->perbaikan_data_id) {
                    return $jenisPerbaikan[$dp->perbaikan_data_id];
                }
                return '';
            })
            ->addColumn('ObjekMutasi', function (PerbaikanModels $dp) {
                if ($dp->perbaikanHasObjek) {
                    return $dp->perbaikanHasObjek->data_manajemen_name;
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
                    '1' => 'Sedang diperbaiki',
                    '2' => 'Selesai diperbaiki',
                    '3' => 'Tidak dapat diperbaiki',
                    
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
        $dataPegawai = PegawaiModels::get();
        return \view('transaksi.perbaikan/tambah', \compact('dataPegawai'));
    }

    public function getObejkPerbaikan(Request $request)
    {
        $getObejkPerbaikan = DataManajemenModels::where('data_manajemen_kode_id', $request->id)
        ->orderBy('data_manajemen_name', 'desc')
        ->pluck('data_manajemen_name', 'data_manajemen_id');
            
        return response()->json($getObejkPerbaikan);
    }
    
     public function getPegawiPerbaikan(Request $request)
    {
        $getPegawiPerbaikan = TransaksiDataModel ::with('trsHasPegawai',)
        ->where('trs_data_id', $request->id)
        ->orderBy('trs_id', 'asc')->get()
        // ->map('trsHasPegawai.pegawai_name', 'trsHasPegawai.pegawai_id');
        ->map(function ($p){
            return [
                'id' => $p->trs_id,
                'id_peg' => $p->trsHasPegawai->pegawai_id,
                'pegawe_name' => $p->trsHasPegawai->pegawai_name,
            ];
        });
       
            // dd($getPegawiPerbaikan);
        return response()->json($getPegawiPerbaikan);
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
            'perbaikan_status' => 1
        ];
        
        $updateTrs = PerbaikanModels::insert($save);

        $cek = \Log::channel('database')->info($updateTrs);
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
        $dataPegawai = PegawaiModels::get();
        $opjekPerbaikan = DataManajemenModels::get();
       
        $dataPerbaikan = PerbaikanModels::orderBy('perbaikan_id', 'desc')->with(['perbaikanHasObjek'=> function ($q){
            $q->with('manajemenHasKondisi');
        }, 'perbaikanHasPegawai' => function($q){
            $q->with('pegawaiHasBagian');
            $q->with('pegawaiHasSubBagian');
        },'perbaikanHasTrs'=> function($q) use ($trs_id){
            $q->with('trsHasGedung');
            $q->with('trsHasRuangan');
            $q->where('trs_id', $trs_id);
        }])->where('perbaikan_id', $id)->first();
        // dd($dataPerbaikan);
        return \view('transaksi/perbaikan.edit', \compact('dataPegawai', 'dataPerbaikan', 'opjekPerbaikan'));
       
    }

    public function update(Request $request,$id)
    {
        $data = explode(":", $request->pegawai);
        
        if(isset($data[1])){
            $trs_id = (int)$data[1];
        }else{
            $trs_id =null;
        }
        if(isset($data[0])){
            $pegawai_id = (int)$data[0];
        }else{
            $pegawai_id = '';
        }

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
        if($trs_id){
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
                'perbaikan_status' =>$request->status,
            ];
            $perbaikan =PerbaikanModels::where('pengembalian_id', $id)->update($save);
        }else{
            $save = [
                'perbaikan_data_id'=> $request->data_perbaikan,
                'perbaikan_objek_id'=> $request->obj,
                'perbaikan_pegawai_id'=> $pegawai_id,
                // 'perbaikan_trs_id'=> $trs_id,
                'perbaikan_tgl_in'=> $request->tglPerbikan,
                'perbaikan_estimasi'=>$request->estimasi,
                'perbaikan_keterangan'=>$request->ketPerbaikan,
                'perbaikan_pic_id'=> Auth::user()->id,
                'perbaikan_tgl'=> Carbon::today(),
                'perbaikan_status' =>$request->status,
            ];
            $perbaikan =PerbaikanModels::where('perbaikan_id', $id)->update($save);
        }

        $cek = \Log::channel('database')->info($perbaikan);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('update transaksi perbaikan' ,json_encode($query));
        
        Alert::success('Success', 'Data berhasil di Simpan');
        return redirect('transaksi_data/perbaikan');
    }
}
