<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\GedungModels;
use App\Models\MutasiModels;
use Illuminate\Http\Request;
use App\Models\KondisiModels;
use App\Models\PegawaiModels;
use App\Models\RuanganModels;
use App\Models\MutasiHasDetail;
use App\Models\ParBagianModels;
use App\Models\SubBagianModels;
use App\Models\TransaksiDataModel;
use Illuminate\Support\Facades\DB;
use App\Models\DataManajemenModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class MutasiController extends Controller
{
    public function index()
    {
        return \view('transaksi/mutasi.index');
    }

    public function getDtaMutasi(Request $request)
    {
        $getMutasi = MutasiModels::with(['MutasiHasPegawai', 'mutasiHasKondisi', 'MutasiHasDetail'=> function($q){
            $q->with('DetailMutasiHasPegawai');
        }, 'MutasiHasBagian', 'MutasiHasSubBagian', 'MutasiHasGedung', 'MutasiHasRuangan'])->get();
        // dd($getMutasi);
        return DataTables::of($getMutasi)
            // ->addColumn('actions', 'transaksi/perangkat.actions')
            ->addColumn('details_url', function(MutasiModels $dp) {
               if ($dp) {
                   $btn = '<button data-url="'.route("detailMutasi",['id_trs'=>$dp->mutasi_trs_id]).'" data-toggle="tooltip" data-placement="top" title="Detail" class="btn btn-success mr-1 btn-sm cek">Detail</button>';
                    $btn = $btn.'<a href="'.route("editMutasi",['id'=>$dp->mutasi_id]).'" class="edit btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit">Edit</a>';
                   return $btn;
                }
                return '';
            })
            ->addColumn('ObjekMutasi', function (MutasiModels $dp) {
                if ($dp->mutasiHasManajemen) {
                    return $dp->mutasiHasManajemen->data_manajemen_name;
                }
                return '';
            })
            ->addColumn('terimaMutasi', function (MutasiModels $dp) {
                if ($dp->MutasiHasPegawai) {
                    return $dp->MutasiHasPegawai->pegawai_name;
                }
                return '';
            })
            ->addColumn('kondisi', function (MutasiModels $dt) {
                if ($dt->mutasiHasKondisi) {
                    return $dt->mutasiHasKondisi->nama_data_kondisi;
                }
                return '';
            })
             ->addColumn('bagian', function (MutasiModels $dp) {
            if ($dp->MutasiHasBagian) {
                return $dp->MutasiHasBagian->nama_bagian;
            }
            return '';
            })
            ->addColumn('subBagian', function (MutasiModels $dp) {
                if ($dp->MutasiHasSubBagian) {
                    return $dp->MutasiHasSubBagian->sub_bagian_nama;
                }
                return '';
            })
            ->addColumn('gedung', function (MutasiModels $dp) {
                if ($dp->MutasiHasGedung) {
                    return $dp->MutasiHasGedung->nama_data_gedung;
                }
                return '';
            })
            ->addColumn('ruangan', function (MutasiModels $dp) {
                if ($dp->MutasiHasRuangan) {
                    return $dp->MutasiHasRuangan->nama_data_ruangan;
                }
                return '';
            })
            ->addColumn('pegawaiSebelumnya', function (MutasiModels $dm) {
                if ($dm->MutasiHasDetail->DetailMutasiHasPegawai) {
                    return $dm->MutasiHasDetail->DetailMutasiHasPegawai->pegawai_name;
                }
                return '';
            })
            ->rawColumns(['actions', 'terimaMutasi', 'kondisi','details_url', 'pegawaiSebelumnya'])
            ->addIndexColumn()
            ->make(true);
    }

    public function detailMutasi($id_trs)
    {
        $detailMutasi = MutasiHasDetail::with(['mutasiParent','DetailMutasiHasPegawai', 'DetailMutasiHasBagian', 'DetailMutasiHasSubBagian', 'DetailMutasiHasGedung', 'DetailMutasiHasRuangan', 'DetailMutasiHasKondisi'])->where('detail_mutasi_trs_id', $id_trs)->orderBy('detail_id', 'asc')->get();

        return DataTables::of($detailMutasi)
        ->addColumn('keterangan', function (MutasiHasDetail $dp) {
            if ($dp->mutasiParent) {
                return $dp->mutasiParent->mutasi_keterangan;
            }
            return '';
        })
        ->addColumn('objek', function (MutasiHasDetail $dp) {
            if ($dp->mutasiParent->mutasiHasManajemen) {
                return $dp->mutasiParent->mutasiHasManajemen->data_manajemen_name;
            }
            return '';
        })
        ->addColumn('pegawai', function (MutasiHasDetail $dp) {
            if ($dp->DetailMutasiHasPegawai) {
                return $dp->DetailMutasiHasPegawai->pegawai_name;
            }
            return '';
        })
        ->addColumn('bagian', function (MutasiHasDetail $dp) {
            if ($dp->DetailMutasiHasBagian) {
                return $dp->DetailMutasiHasBagian->nama_bagian;
            }
            return '';
        })
        ->addColumn('subBagian', function (MutasiHasDetail $dp) {
            if ($dp->DetailMutasiHasSubBagian) {
                return $dp->DetailMutasiHasSubBagian->sub_bagian_nama;
            }
            return '';
        })
        ->addColumn('gedung', function (MutasiHasDetail $dp) {
            if ($dp->DetailMutasiHasGedung) {
                return $dp->DetailMutasiHasGedung->nama_data_gedung;
            }
            return '';
        })
        ->addColumn('ruangan', function (MutasiHasDetail $dp) {
            if ($dp->DetailMutasiHasRuangan) {
                return $dp->DetailMutasiHasRuangan->nama_data_ruangan;
            }
            return '';
        })
        ->addColumn('kondisi', function (MutasiHasDetail $dp) {
            if ($dp->DetailMutasiHasKondisi) {
                return $dp->DetailMutasiHasKondisi->nama_data_kondisi;
            }
            return '';
        })
        ->rawColumns(['keterangan','pegawai', 'objek'])
        ->addIndexColumn()
        ->make(true);

        // dd($detailMutasi);
    }

    public function tambah()
    {
        $dataPegawai = PegawaiModels::get();
        $datakondisi = KondisiModels::get();
        $gedung = GedungModels::get();
        $ruangan = RuanganModels::get();
        return \view('transaksi/mutasi.tambah', \compact('dataPegawai', 'datakondisi','gedung', 'ruangan'));
    }
    
    public function getObejkMutasi(Request $request)
    {
        $getOjekMutasi = DataManajemenModels::where('data_manajemen_kode_id', $request->id)
        ->orderBy('data_manajemen_name', 'desc')
        ->pluck('data_manajemen_name', 'data_manajemen_id');
            
        return response()->json($getOjekMutasi);
    }

    public function getPegawiMutasi(Request $request)
    {
        $getPegawiMutasi = TransaksiDataModel ::with('trsHasPegawai',)
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
       
            // dd($getPegawiMutasi);
        return response()->json($getPegawiMutasi);
    }

    public function getRekapMutasi(Request $request)
    {
        $data = explode(":", $request->id);
        $pegawai_id = (int)$data[0];
        $trs_id = (int)$data[1];

        $getRekapMutasi_ = TransaksiDataModel ::with(['trsHasBagian', 'trsHasSubBagian', 'trsHasGedung','trsHasRuangan', 'trsHasData'=> function ($q){
            $q->with('manajemenHasKondisi');
        }])
        ->where('trs_id', $trs_id)
        ->where('trs_pegawai_id', $pegawai_id)
        ->first();

       return response()->json($getRekapMutasi_);
        
    }

    public function save(Request $request)
    {
        // dd($request->all());
        $data = explode(":", $request->pegawai);
        $pegawai_id = (int)$data[0];
        $trs_id = (int)$data[1];

        $request->validate([
            'ketMutasi' => 'required',
            'data_mutasi' => 'required',
            'obj' => 'required',
            'kePegawai' => 'required',
            'bagian' => 'required',
            'subBagian' => 'required',
            'gedung' => 'required',
            'ruangan' => 'required',
            'kondisi' => 'required',
            
        ],
        [
            'ketMutasi.required' => 'Keterangan Mutasi tidak boleh kosong!',
            'data_mutasi.required' => 'Data Mutasi tidak boleh kosong!',
            'obj.required' => ' Objek Mutasi tidak boleh kosong!',
            'kePegawai.required' => 'Pegawai Sekarang tidak boleh kosong!',
            'bagian.required' => 'Bagian tidak boleh kosong!',
            'subBagian.required' => 'Sub Bagian tidak boleh kosong!',
            'gedung.required' => 'Gedung tidak boleh kosong!',
            'ruangan.required' => 'Ruangan tidak boleh kosong!',
            'kondisi.required' => 'Kondisi tidak boleh kosong!',
        ]);
        
        $save = [
            'mutasi_keterangan'=> $request->ketMutasi,
            'mutasi_data_id'=> $request->data_mutasi,
            'mutasi_objek_id'=> $request->obj,
            'mutasi_pegawai_id'=> $request->kePegawai,
            'mutasi_kondisi_id'=> $request->kondisi,
            'mutasi_bagian_id'=>$request->bagian_,
            'mutasi_sub_bagian_id'=>$request->subBagian_,
            'mutasi_gedung_id'=>$request->gedung,
            'mutasi_ruangan_id'=> $request->ruangan,
            'mutasi_trs_id'=> $trs_id,
            'mutasi_pic_id'=> Auth::user()->id,
            'mutasi_tgl'=> Carbon::today(),
        ];
        $mutasi =MutasiModels::create($save);

        $cek = \Log::channel('database')->info($mutasi);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('tambah data mutasi' ,json_encode($query));
        
        $detailMutasi = [
            'detail_mutasi_id'=>$mutasi->mutasi_id,
            'detail_mutasi_trs_id'=> $trs_id,
            'detail_mutasi_pegawai_id'=> $request->pegawai,
            'detail_mutasi_bagian_id'=> $request->bagian_detail_id,
            'detail_mutasi_sub_bagian_id'=> $request->sub_bagian_detail_id,
            'detail_mutasi_gedung_id'=>$request->gedung_detail_id,
            'detail_mutasi_ruangan_id'=>$request->ruangan_detail_id,
            'detail_mutasi_kondisi_id'=> $request->kds_detail_id,
            'detail_mutasi_tgl'=> Carbon::today(),
        ];

        $save_detail = DB::table('mutasi_has_detail')->insert($detailMutasi);
        
        $mutasiTrs = [
            'trs_pegawai_id' => $request->kePegawai,
            'trs_bagian_id' => $request->bagian_,
            'trs_sub_bagian_id' => $request->subBagian_,
            'trs_gedung_id' => $request->gedung,
            'trs_ruangan_id' => $request->ruangan,
            'trs_kondisi_id' => $request->kondisi,
            'trs_status_id' => 5,
            'trs_pic_id'=> Auth::user()->id,
            'trs_date'=> Carbon::today(),
        ];
        $updateTrs = TransaksiDataModel::where('trs_id',$trs_id)->update($mutasiTrs);

        $product = DataManajemenModels::find($request->obj);
        $product->increment('data_manajemen_jumlah_mutasi', 1);
        
        Alert::success('Success', 'Data berhasil di Simpan');
        return redirect('transaksi_data/mutasi');
    }

    public function edit($id){
        $editMutasi = MutasiModels::with(['MutasiHasPegawai', 'mutasiHasKondisi', 'MutasiHasDetail'=> function($q){
            $q->with(['mutasiParent','DetailMutasiHasPegawai', 'DetailMutasiHasBagian', 'DetailMutasiHasSubBagian', 'DetailMutasiHasGedung', 'DetailMutasiHasRuangan', 'DetailMutasiHasKondisi']);
        }, 'MutasiHasBagian', 'MutasiHasSubBagian', 'MutasiHasGedung', 'MutasiHasRuangan'])->first();
        // dd($editMutasi); 

        $dataPegawai = PegawaiModels::get();
        $datakondisi = KondisiModels::get();
        $Bagian = ParBagianModels::get();
        $gedung = GedungModels::get();
        $ruangan = RuanganModels::get();
        $objekMutasi = DataManajemenModels::get();
        $subBagian = SubBagianModels::where('sub_bagian_bagian_id',$editMutasi->mutasi_bagian_id)->get();
        return \view('transaksi/mutasi.edit', \compact('editMutasi','dataPegawai', 'datakondisi', 'Bagian','gedung', 'ruangan', 'objekMutasi', 'subBagian'));
    }

    public function update(Request $request, $id){
       
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
            'ketMutasi' => 'required',
            'data_mutasi' => 'required',
            'obj' => 'required',
            'kePegawai' => 'required',
            'bagian' => 'required',
            'subBagian' => 'required',
            'gedung' => 'required',
            'ruangan' => 'required',
            'kondisi' => 'required',
            
        ],
        [
            'ketMutasi.required' => 'Keterangan Mutasi tidak boleh kosong!',
            'data_mutasi.required' => 'Data Mutasi tidak boleh kosong!',
            'obj.required' => ' Objek Mutasi tidak boleh kosong!',
            'kePegawai.required' => 'Pegawai Sekarang tidak boleh kosong!',
            'bagian.required' => 'Bagian tidak boleh kosong!',
            'subBagian.required' => 'Sub Bagian tidak boleh kosong!',
            'gedung.required' => 'Gedung tidak boleh kosong!',
            'ruangan.required' => 'Ruangan tidak boleh kosong!',
            'kondisi.required' => 'Kondisi tidak boleh kosong!',
        ]);
        if($trs_id){
            $save1 = [
                'mutasi_keterangan'=> $request->ketMutasi,
                'mutasi_data_id'=> $request->data_mutasi,
                'mutasi_objek_id'=> $request->obj,
                'mutasi_pegawai_id'=> $request->kePegawai,
                'mutasi_kondisi_id'=> $request->kondisi,
                'mutasi_bagian_id'=>$request->bagian_,
                'mutasi_sub_bagian_id'=>$request->subBagian_,
                'mutasi_gedung_id'=>$request->gedung,
                'mutasi_ruangan_id'=> $request->ruangan,
                'mutasi_trs_id'=> $trs_id,
                'mutasi_pic_id'=> Auth::user()->id,
                'mutasi_tgl'=> Carbon::today(),
            ];
            $mutasi =MutasiModels::where('mutasi_id', $id)->update($save1);

            $cek = \Log::channel('database')->info($mutasi);
            $query = DB::getQueryLog();
            $query = end($query);
            $this->save_log('edit data mutasi' ,json_encode($query));

        }else{
            $save2 = [
                'mutasi_keterangan'=> $request->ketMutasi,
                'mutasi_data_id'=> $request->data_mutasi,
                'mutasi_objek_id'=> $request->obj,
                'mutasi_pegawai_id'=> $request->kePegawai,
                'mutasi_kondisi_id'=> $request->kondisi,
                'mutasi_bagian_id'=>$request->bagian_,
                'mutasi_sub_bagian_id'=>$request->subBagian_,
                'mutasi_gedung_id'=>$request->gedung,
                'mutasi_ruangan_id'=> $request->ruangan,
                // 'mutasi_trs_id'=> $trs_id,
                'mutasi_pic_id'=> Auth::user()->id,
                'mutasi_tgl'=> Carbon::today(),
            ];
            $mutasi =MutasiModels::where('mutasi_id', $id)->update($save2);

            $cek = \Log::channel('database')->info($mutasi);
            $query = DB::getQueryLog();
            $query = end($query);
            $this->save_log('edit data mutasi' ,json_encode($query));

        }
        
       
        if($trs_id){
            $detailMutasi1 = [
                'detail_mutasi_id'=>$mutasi->mutasi_id,
                'detail_mutasi_trs_id'=> $trs_id,
                'detail_mutasi_pegawai_id'=> $request->pegawai,
                'detail_mutasi_bagian_id'=> $request->bagian_detail_id,
                'detail_mutasi_sub_bagian_id'=> $request->sub_bagian_detail_id,
                'detail_mutasi_gedung_id'=>$request->gedung_detail_id,
                'detail_mutasi_ruangan_id'=>$request->ruangan_detail_id,
                'detail_mutasi_kondisi_id'=> $request->kds_detail_id,
                'detail_mutasi_tgl'=> Carbon::today(),
            ];
                $save_detail = DB::table('mutasi_has_detail')->where('detail_mutasi_id', $id)->update($detailMutasi1);
        }else{
            $detailMutasi2 = [
                'detail_mutasi_pegawai_id'=> $request->pegawai,
                'detail_mutasi_bagian_id'=> $request->bagian_detail_id,
                'detail_mutasi_sub_bagian_id'=> $request->sub_bagian_detail_id,
                'detail_mutasi_gedung_id'=>$request->gedung_detail_id,
                'detail_mutasi_ruangan_id'=>$request->ruangan_detail_id,
                'detail_mutasi_kondisi_id'=> $request->kds_detail_id,
                'detail_mutasi_tgl'=> Carbon::today(),
            ];
                $save_detail = DB::table('mutasi_has_detail')->where('detail_mutasi_id', $id)->update($detailMutasi2);
        }

       
        if($trs_id){
            $mutasiTrs = [
                'trs_pegawai_id' => $request->kePegawai,
                'trs_bagian_id' => $request->bagian_,
                'trs_sub_bagian_id' => $request->subBagian_,
                'trs_gedung_id' => $request->gedung,
                'trs_ruangan_id' => $request->ruangan,
                'trs_kondisi_id' => $request->kondisi,
                'trs_status_id' => 5,
                'trs_pic_id'=> Auth::user()->id,
                'trs_date'=> Carbon::today(),
            ];
            $updateTrs = TransaksiDataModel::where('trs_id',$trs_id)->update($mutasiTrs);
        }
        Alert::success('Success', 'Data berhasil di Simpan');
        return redirect('transaksi_data/mutasi');
       
    }

}
