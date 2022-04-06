<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\StokModels;
use App\Models\GedungModels;
use App\Models\MutasiModels;
use Illuminate\Http\Request;
use App\Models\KondisiModels;
use App\Models\PegawaiModels;
use App\Models\RuanganModels;
use App\Models\DetailTransaksi;
use App\Models\MutasiHasDetail;
use App\Models\ParBagianModels;
use App\Models\SubBagianModels;
use App\Models\TransaksiModels;
use App\Models\TypeKtegoryModels;
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
        $getMutasi = MutasiModels::with(['MutasiHasPegawai', 'mutasiHasKondisi', 'MutasiHasDetail'=> function($q){
            $q->with(['DetailMutasiHasPegawai'=> function ($q){
                $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
            }]);
        }, 'MutasiHasGedung', 'MutasiHasRuangan', 'MutasiHasType'])->get();
        // dd($getMutasi);
        return \view('transaksi/mutasi.index');
    }

    public function getDtaMutasi(Request $request)
    {
        $getMutasi = MutasiModels::with(['MutasiHasPegawai'=>function ($q){
            $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
        }, 'mutasiHasKondisi', 'MutasiHasDetail'=> function($q){
            $q->with(['DetailMutasiHasPegawai'=> function ($q){
                $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
            }]);
        }, 'MutasiHasGedung', 'MutasiHasRuangan', 'MutasiHasType'])->get();
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
                if ($dp->MutasiHasType) {
                    return $dp->MutasiHasType->data_name;
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
                if ($dp->MutasiHasPegawai) {
                    if($dp->MutasiHasPegawai->pegawaiHasBagian)
                        return $dp->MutasiHasPegawai->pegawaiHasBagian->nama_bagian;
                }
                return '';
            })
            ->addColumn('subBagian', function (MutasiModels $dp) {
                if ($dp->MutasiHasPegawai) {
                    if($dp->MutasiHasPegawai->pegawaiHasSubBagian)
                        return $dp->MutasiHasPegawai->pegawaiHasSubBagian->sub_bagian_nama;
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
        $detailMutasi = MutasiHasDetail::with(['mutasiParent','DetailMutasiHasPegawai'=> function($q){
            $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
        }, 'DetailMutasiHasGedung', 'DetailMutasiHasRuangan', 'DetailMutasiHasKondisi'])->where('detail_mutasi_trs_id', $id_trs)->orderBy('detail_id', 'asc')->get();

        return DataTables::of($detailMutasi)
        ->addColumn('keterangan', function (MutasiHasDetail $dp) {
            if ($dp->mutasiParent) {
                return $dp->mutasiParent->mutasi_keterangan;
            }
            return '';
        })
        ->addColumn('objek', function (MutasiHasDetail $dp) {
            if ($dp->mutasiParent->MutasiHasStok) {
                return $dp->mutasiParent->MutasiHasStok->data_name;
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
            if ($dp->DetailMutasiHasPegawai) {
                if($dp->DetailMutasiHasPegawai->pegawaiHasBagian){
                    return $dp->DetailMutasiHasPegawai->pegawaiHasBagian->nama_bagian;
                }
            }
            return '';
        })
        ->addColumn('subBagian', function (MutasiHasDetail $dp) {
            if ($dp->DetailMutasiHasPegawai) {
                if($dp->DetailMutasiHasPegawai->pegawaiHasSubBagian){
                    return $dp->DetailMutasiHasPegawai->pegawaiHasSubBagian->sub_bagian_nama;
                }
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
        $type = TypeKtegoryModels::get();
        $ruangan = RuanganModels::get();
        return \view('transaksi/mutasi.tambah', \compact('dataPegawai', 'datakondisi','gedung', 'ruangan', 'type'));
    }
    
    public function getObejkMutasi(Request $request)
    {
        $getOjekMutasi = StokModels::where('data_kategory_id', $request->id)
        ->orderBy('data_stok_id', 'desc')
        ->pluck('data_name', 'data_stok_id');
            
        return response()->json($getOjekMutasi);
    }

    public function getPegawiMutasi(Request $request)
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
       
            // dd($getPegawiMutasi);
        return response()->json($getPegawiMutasi);
    }

    public function save(Request $request)
    {
        // dd($request->all());
        $data = explode(":", $request->pegawai);
        $pegawai_id = (int)$data[0];
        $trs_id = (int)$data[1];

        $request->validate([
            'ketMutasi' => 'required',
            'typeMutasi' => 'required',
            'obj' => 'required',
            'kePegawai' => 'required',
            'gedung' => 'required',
            'ruangan' => 'required',
            'kondisi' => 'required',
        ],
        [
            'ketMutasi.required' => 'Keterangan Mutasi tidak boleh kosong!',
            'data_mutasi.required' => 'Data Mutasi tidak boleh kosong!',
            'obj.required' => ' Objek Mutasi tidak boleh kosong!',
            'kePegawai.required' => 'Pegawai Sekarang tidak boleh kosong!',
            'gedung.required' => 'Gedung tidak boleh kosong!',
            'ruangan.required' => 'Ruangan tidak boleh kosong!',
            'kondisi.required' => 'Kondisi tidak boleh kosong!',
        ]);
        
        $save = [
            'mutasi_keterangan'=> $request->ketMutasi,
            'mutasi_data_id'=> $request->typeMutasi,
            'mutasi_objek_id'=> $request->obj,
            'mutasi_pegawai_id'=> $request->kePegawai,
            'mutasi_kondisi_id'=> $request->kondisi,
            'mutasi_gedung_id'=>$request->gedung,
            'mutasi_ruangan_id'=> $request->ruangan,
            'mutasi_trs_id'=> $trs_id,
            'mutasi_pic_id'=> Auth::user()->id,
            'mutasi_tgl'=> Carbon::today(),
        ];
        $mutasi =MutasiModels::create($save);

        $cek = Log::channel('database')->info($mutasi);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('tambah data mutasi' ,json_encode($query));
        
        $detailMutasi = [
            'detail_mutasi_id'=>$mutasi->mutasi_id,
            'detail_mutasi_trs_id'=> $trs_id,
            'detail_mutasi_pegawai_id'=> $request->pegawai,
            'detail_mutasi_gedung_id'=>$request->gedung,
            'detail_mutasi_ruangan_id'=>$request->ruangan,
            'detail_mutasi_kondisi_id'=> $request->kondisi,
            'detail_mutasi_tgl'=> Carbon::today(),
        ];

        $save_detail = DB::table('mutasi_has_detail')->insert($detailMutasi);
        
        $mutasiTrs = [
            'trs_detail_pegawai_id' => $request->kePegawai,
            'trs_detail_gedung_id' => $request->gedung,
            'trs_detail_ruangan_id' => $request->ruangan,
            'trs_detail_status' => 5,
            'trs_detail_pic_id'=> Auth::user()->id,
            'trs_detail_date'=> Carbon::today(),
        ];
        $updateTrs = DetailTransaksi::where('trs_detail_id',$trs_id)->update($mutasiTrs);

        // $product = DataManajemenModels::find($request->obj);
        // $product->increment('data_manajemen_jumlah_mutasi', 1);
        
        Alert::success('Success', 'Data berhasil di Simpan');
        return redirect('transaksi_data/mutasi');
    }

    public function edit($id){
        $editMutasi = MutasiModels::with(['MutasiHasPegawai', 'MutasiHasDetail'=> function($q){
            $q->with(['mutasiParent','DetailMutasiHasPegawai', 'DetailMutasiHasGedung', 'DetailMutasiHasRuangan', 'DetailMutasiHasKondisi']);
        }, 'MutasiHasGedung', 'MutasiHasRuangan'])->where('mutasi_id',$id)->first();
        // dd($editMutasi); 
 
        $dataPegawai = PegawaiModels::get();
        $datakondisi = KondisiModels::get();
        $gedung = GedungModels::get();
        $ruangan = RuanganModels::get();
        $objekMutasi = StokModels::get();
        $type = TypeKtegoryModels::get();

        return \view('transaksi/mutasi.edit', \compact('editMutasi','dataPegawai', 'datakondisi','gedung', 'ruangan', 'objekMutasi', 'type'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ketMutasi' => 'required',
            'typeMutasi' => 'required',
            'obj' => 'required',
            'kePegawai' => 'required',
            'gedung' => 'required',
            'ruangan' => 'required',
            'kondisi' => 'required',
        ],
        [
            'ketMutasi.required' => 'Keterangan Mutasi tidak boleh kosong!',
            'data_mutasi.required' => 'Data Mutasi tidak boleh kosong!',
            'obj.required' => ' Objek Mutasi tidak boleh kosong!',
            'kePegawai.required' => 'Pegawai Sekarang tidak boleh kosong!',
            'gedung.required' => 'Gedung tidak boleh kosong!',
            'ruangan.required' => 'Ruangan tidak boleh kosong!',
            'kondisi.required' => 'Kondisi tidak boleh kosong!',
        ]);
        $detailMutasi = [
            'detail_mutasi_trs_id'=> $request->detail_trs_id,
            'detail_mutasi_pegawai_id'=> $request->pegawai,
            
        ];
      
        $update_detail = MutasiHasDetail::where('detail_id',$request->detail_mutasi)->update($detailMutasi);

        $save1 = [
            'mutasi_keterangan'=> $request->ketMutasi,
            'mutasi_data_id'=> $request->typeMutasi,
            'mutasi_objek_id'=> $request->obj,
            'mutasi_pegawai_id'=> $request->kePegawai,
            'mutasi_kondisi_id'=> $request->kondisi,
            'mutasi_gedung_id'=>$request->gedung,
            'mutasi_ruangan_id'=> $request->ruangan,
            'mutasi_trs_id'=> $request->detail_trs_id,
            'mutasi_pic_id'=> Auth::user()->id,
            'mutasi_tgl'=> Carbon::today(),
        ];

        $mutasi =MutasiModels::where('mutasi_id', $request->mutasi_id)->update($save1);

       
        $mutasiTrs = [
            'trs_detail_pegawai_id' => $request->kePegawai,
            'trs_detail_gedung_id'=>$request->gedung,
            'trs_detail_ruangan_id' => $request->ruangan,
            'trs_detail_status' => 5,
            'trs_detail_pic_id'=> Auth::user()->id,
            'trs_detail_date'=> Carbon::today(),
        ];
        $updateTrsMutasi = DetailTransaksi::where('trs_detail_id',$request->detail_trs_id)->update($mutasiTrs);
       
        Alert::success('Success', 'Data berhasil di Simpan');
        return redirect('transaksi_data/mutasi');
       
    }

}
