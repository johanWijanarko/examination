<?php

namespace App\Http\Controllers;

use App\Models\GedungModels;
use Illuminate\Http\Request;
use App\Models\RuanganModels;
use App\Models\PengembalianModels;

class LaporanPengembalian extends Controller
{
    public function index(Request $request)
    {
        if ($request->all()) {
         $datakembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek', 'kembaliHasPegawai' => function($q){
            $q->with('pegawaiHasBagian');
            $q->with('pegawaiHasSubBagian');
        }, 'kembaliHasKondisiSkrg', 'kembaliHasKondisiSblm'])->where('pengembalian_data_id', 1)
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('pengembalian_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })->get();

        return \view('laporan/pengembalian.perangkat', \compact('datakembali'));
        }
            $datakembali = [];
            // $gedung = [];
            return \view('laporan/pengembalian.perangkat', \compact('datakembali'));

    }

    public function kem_prangkat_excel(Request $request)
    {
        $datakembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek' => function($q){
            $q->with('manajemenHasMerk');
            $q->with('manajemenHasType');
            $q->with('manajemenHasSupplier');
        }, 'kembaliHasTrs'=> function($q) {
            $q->with('trsHasGedung');
            $q->with('trsHasRuangan');
            $q->with('trsHasKelompok');
        }, 'kembaliHasPegawai' => function($q){
            $q->with('pegawaiHasBagian');
            $q->with('pegawaiHasSubBagian');
        }])
       ->where('pengembalian_data_id', 1)->get();

       return \view('laporan/pengembalian.perangkatExcel', \compact('datakembali'));
    }

    public function kem_prangkat_gedung(Request $request)
    {
        $gedung = GedungModels::get();
        if ($request->all()) {
         $datakembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek' => function($q) use ($request){
            $q->with(['manajemenHasMerk','manajemenHasType' ,'manajemenHasSupplier' ,]);
            
        }, 'kembaliHasTrs'=> function($q) use($request){
            $q->with(['trsHasGedung','trsHasRuangan','trsHasKelompok',]);
            
            
        }, 'kembaliHasPegawai' => function($q){
            $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
        }])
        ->whereHas('kembaliHasTrs', function ($q) use($request){
            $q->when($request->gedung , function ($q) use ($request) {
                $q->where('trs_gedung_id',$request->gedung);
            });
        })
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('pengembalian_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
       ->where('pengembalian_data_id', 1)->get();


        return \view('laporan/pengembalian.perangkatGedung', \compact('datakembali', 'gedung'));
        }
            $datakembali = [];
            // $gedung = [];
            return \view('laporan/pengembalian.perangkatGedung', \compact('datakembali', 'gedung'));

    }

    public function kem_prangkat_gedung_excel(Request $request)
    {
        $gedung = GedungModels::get();
        $datakembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek' => function($q) use ($request){
            $q->with(['manajemenHasMerk','manajemenHasType' ,'manajemenHasSupplier' ,]);
            
        }, 'kembaliHasTrs'=> function($q) use($request){
            $q->with(['trsHasGedung','trsHasRuangan','trsHasKelompok',]);
            
            
        }, 'kembaliHasPegawai' => function($q){
            $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
        }])
        ->whereHas('kembaliHasTrs', function ($q) use($request){
            $q->when($request->gedung , function ($q) use ($request) {
                $q->where('trs_gedung_id',$request->gedung);
            });
        })
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('pengembalian_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
       ->where('pengembalian_data_id', 1)->get();
       return \view('laporan/pengembalian.perangkatGedungExcel', \compact('datakembali', 'gedung'));
    }

     public function kem_prangkat_ruang(Request $request)
    {
        $ruangan = RuanganModels::get();
        if ($request->all()) {
         $datakembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek' => function($q) use ($request){
            $q->with(['manajemenHasMerk','manajemenHasType' ,'manajemenHasSupplier' ,]);
            
        }, 'kembaliHasTrs'=> function($q) use($request){
            $q->with(['trsHasGedung','trsHasRuangan','trsHasKelompok',]);
            
            
        }, 'kembaliHasPegawai' => function($q){
            $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
        }])
        ->whereHas('kembaliHasTrs', function ($q) use($request){
            $q->when($request->ruangan , function ($q) use ($request) {
                $q->where('trs_ruangan_id',$request->ruangan);
            });
        })
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('pengembalian_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
       ->where('pengembalian_data_id', 1)->get();


        return \view('laporan/pengembalian.perangkatRuangan', \compact('datakembali', 'ruangan'));
        }
            $datakembali = [];
            // $gedung = [];
            return \view('laporan/pengembalian.perangkatRuangan', \compact('datakembali', 'ruangan'));

    }

    public function kem_prangkat_ruang_excel(Request $request)
    {
        // $ruangan = GedungModels::get();
        $datakembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek' => function($q) use ($request){
            $q->with(['manajemenHasMerk','manajemenHasType' ,'manajemenHasSupplier' ,]);
            
        }, 'kembaliHasTrs'=> function($q) use($request){
            $q->with(['trsHasGedung','trsHasRuangan','trsHasKelompok',]);
            
            
        }, 'kembaliHasPegawai' => function($q){
            $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
        }])
        ->whereHas('kembaliHasTrs', function ($q) use($request){
            $q->when($request->ruangan , function ($q) use ($request) {
                $q->where('trs_ruangan_id',$request->ruangan);
            });
        })
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('pengembalian_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
       ->where('pengembalian_data_id', 1)->get();
       return \view('laporan/pengembalian.perangkatRuanganExcel', \compact('datakembali'));
    }


    // aplikasi

    public function aplikasi(Request $request)
    {
        if ($request->all()) {
         $datakembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek', 'kembaliHasPegawai' => function($q){
            $q->with('pegawaiHasBagian');
            $q->with('pegawaiHasSubBagian');
        }, 'kembaliHasKondisiSkrg', 'kembaliHasKondisiSblm'])->where('pengembalian_data_id', 2)
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('pengembalian_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })->get();

        return \view('laporan/pengembalian.aplikasi', \compact('datakembali'));
        }
            $datakembali = [];
            // $gedung = [];
            return \view('laporan/pengembalian.aplikasi', \compact('datakembali'));

    }

    public function kem_aplikasi_excel(Request $request)
    {
        $datakembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek' => function($q){
            $q->with('manajemenHasMerk');
            $q->with('manajemenHasType');
            $q->with('manajemenHasSupplier');
        }, 'kembaliHasTrs'=> function($q) {
            $q->with('trsHasGedung');
            $q->with('trsHasRuangan');
            $q->with('trsHasKelompok');
        }, 'kembaliHasPegawai' => function($q){
            $q->with('pegawaiHasBagian');
            $q->with('pegawaiHasSubBagian');
        }])
       ->where('pengembalian_data_id', 2)->get();

       return \view('laporan/pengembalian.aplikasiExcel', \compact('datakembali'));
    }

    public function kem_aplikasi_gedung(Request $request)
    {
        $gedung = GedungModels::get();
        if ($request->all()) {
         $datakembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek' => function($q) use ($request){
            $q->with(['manajemenHasMerk','manajemenHasType' ,'manajemenHasSupplier' ,]);
            
        }, 'kembaliHasTrs'=> function($q) use($request){
            $q->with(['trsHasGedung','trsHasRuangan','trsHasKelompok',]);
            
            
        }, 'kembaliHasPegawai' => function($q){
            $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
        }])
        ->whereHas('kembaliHasTrs', function ($q) use($request){
            $q->when($request->gedung , function ($q) use ($request) {
                $q->where('trs_gedung_id',$request->gedung);
            });
        })
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('pengembalian_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
       ->where('pengembalian_data_id', 2)->get();


        return \view('laporan/pengembalian.aplikasiGedung', \compact('datakembali', 'gedung'));
        }
            $datakembali = [];
            // $gedung = [];
            return \view('laporan/pengembalian.aplikasiGedung', \compact('datakembali', 'gedung'));

    }

    public function kem_aplikasi_gedung_excel(Request $request)
    {
        $gedung = GedungModels::get();
        $datakembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek' => function($q) use ($request){
            $q->with(['manajemenHasMerk','manajemenHasType' ,'manajemenHasSupplier' ,]);
            
        }, 'kembaliHasTrs'=> function($q) use($request){
            $q->with(['trsHasGedung','trsHasRuangan','trsHasKelompok',]);
            
            
        }, 'kembaliHasPegawai' => function($q){
            $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
        }])
        ->whereHas('kembaliHasTrs', function ($q) use($request){
            $q->when($request->gedung , function ($q) use ($request) {
                $q->where('trs_gedung_id',$request->gedung);
            });
        })
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('pengembalian_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
       ->where('pengembalian_data_id', 2)->get();
       return \view('laporan/pengembalian.aplikasiGedungExcel', \compact('datakembali', 'gedung'));
    }

     public function kem_aplikasi_ruang(Request $request)
    {
        $ruangan = RuanganModels::get();
        if ($request->all()) {
         $datakembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek' => function($q) use ($request){
            $q->with(['manajemenHasMerk','manajemenHasType' ,'manajemenHasSupplier' ,]);
            
        }, 'kembaliHasTrs'=> function($q) use($request){
            $q->with(['trsHasGedung','trsHasRuangan','trsHasKelompok',]);
            
            
        }, 'kembaliHasPegawai' => function($q){
            $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
        }])
        ->whereHas('kembaliHasTrs', function ($q) use($request){
            $q->when($request->ruangan , function ($q) use ($request) {
                $q->where('trs_ruangan_id',$request->ruangan);
            });
        })
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('pengembalian_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
       ->where('pengembalian_data_id', 2)->get();


        return \view('laporan/pengembalian.aplikasiRuangan', \compact('datakembali', 'ruangan'));
        }
            $datakembali = [];
            // $gedung = [];
            return \view('laporan/pengembalian.aplikasiRuangan', \compact('datakembali', 'ruangan'));

    }

    public function kem_aplikasi_ruang_excel(Request $request)
    {
        // $ruangan = GedungModels::get();
        $datakembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek' => function($q) use ($request){
            $q->with(['manajemenHasMerk','manajemenHasType' ,'manajemenHasSupplier' ,]);
            
        }, 'kembaliHasTrs'=> function($q) use($request){
            $q->with(['trsHasGedung','trsHasRuangan','trsHasKelompok',]);
            
            
        }, 'kembaliHasPegawai' => function($q){
            $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
        }])
        ->whereHas('kembaliHasTrs', function ($q) use($request){
            $q->when($request->ruangan , function ($q) use ($request) {
                $q->where('trs_ruangan_id',$request->ruangan);
            });
        })
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('pengembalian_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
       ->where('pengembalian_data_id', 2)->get();
       return \view('laporan/pengembalian.aplikasiRuanganExcel', \compact('datakembali'));
    }


     // ATK

    public function atk(Request $request)
    {
        if ($request->all()) {
         $datakembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek', 'kembaliHasPegawai' => function($q){
            $q->with('pegawaiHasBagian');
            $q->with('pegawaiHasSubBagian');
        }, 'kembaliHasKondisiSkrg', 'kembaliHasKondisiSblm'])->where('pengembalian_data_id', 3)
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('pengembalian_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })->get();

        return \view('laporan/pengembalian.atk', \compact('datakembali'));
        }
            $datakembali = [];
            // $gedung = [];
            return \view('laporan/pengembalian.atk', \compact('datakembali'));

    }

    public function kem_atk_excel(Request $request)
    {
        $datakembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek' => function($q){
            $q->with('manajemenHasMerk');
            $q->with('manajemenHasType');
            $q->with('manajemenHasSupplier');
        }, 'kembaliHasTrs'=> function($q) {
            $q->with('trsHasGedung');
            $q->with('trsHasRuangan');
            $q->with('trsHasKelompok');
        }, 'kembaliHasPegawai' => function($q){
            $q->with('pegawaiHasBagian');
            $q->with('pegawaiHasSubBagian');
        }])
       ->where('pengembalian_data_id', 3)->get();

       return \view('laporan/pengembalian.atkExcel', \compact('datakembali'));
    }

    public function kem_atk_gedung(Request $request)
    {
        $gedung = GedungModels::get();
        if ($request->all()) {
         $datakembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek' => function($q) use ($request){
            $q->with(['manajemenHasMerk','manajemenHasType' ,'manajemenHasSupplier' ,]);
            
        }, 'kembaliHasTrs'=> function($q) use($request){
            $q->with(['trsHasGedung','trsHasRuangan','trsHasKelompok',]);
            
            
        }, 'kembaliHasPegawai' => function($q){
            $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
        }])
        ->whereHas('kembaliHasTrs', function ($q) use($request){
            $q->when($request->gedung , function ($q) use ($request) {
                $q->where('trs_gedung_id',$request->gedung);
            });
        })
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('pengembalian_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
       ->where('pengembalian_data_id', 3)->get();


        return \view('laporan/pengembalian.atkGedung', \compact('datakembali', 'gedung'));
        }
        $datakembali = [];
        // $gedung = [];
        return \view('laporan/pengembalian.atkGedung', \compact('datakembali', 'gedung'));

    }

    public function kem_atk_gedung_excel(Request $request)
    {
        // dd($request->all());
        $gedung = GedungModels::get();
        $datakembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek' => function($q) use ($request){
            $q->with(['manajemenHasMerk','manajemenHasType' ,'manajemenHasSupplier' ,]);
            
        }, 'kembaliHasTrs'=> function($q) use($request){
            $q->with(['trsHasGedung','trsHasRuangan','trsHasKelompok',]);
            
            
        }, 'kembaliHasPegawai' => function($q){
            $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
        }])
        ->whereHas('kembaliHasTrs', function ($q) use($request){
            $q->when($request->gedung , function ($q) use ($request) {
                $q->where('trs_gedung_id',$request->gedung);
            });
        })
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('pengembalian_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
       ->where('pengembalian_data_id', 3)->get();
       return \view('laporan/pengembalian.atkGedungExcel', \compact('datakembali', 'gedung'));
    }

     public function kem_atk_ruang(Request $request)
    {
        $ruangan = RuanganModels::get();
        if ($request->all()) {
         $datakembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek' => function($q) use ($request){
            $q->with(['manajemenHasMerk','manajemenHasType' ,'manajemenHasSupplier' ,]);
            
        }, 'kembaliHasTrs'=> function($q) use($request){
            $q->with(['trsHasGedung','trsHasRuangan','trsHasKelompok',]);
            
            
        }, 'kembaliHasPegawai' => function($q){
            $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
        }])
        ->whereHas('kembaliHasTrs', function ($q) use($request){
            $q->when($request->ruangan , function ($q) use ($request) {
                $q->where('trs_ruangan_id',$request->ruangan);
            });
        })
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('pengembalian_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
       ->where('pengembalian_data_id', 3)->get();


        return \view('laporan/pengembalian.atkRuangan', \compact('datakembali', 'ruangan'));
        }
            $datakembali = [];
            // $gedung = [];
            return \view('laporan/pengembalian.atkRuangan', \compact('datakembali', 'ruangan'));

    }

    public function kem_atk_ruang_excel(Request $request)
    {
        // dd($request->all());
        // $ruangan = GedungModels::get();
        $datakembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek' => function($q) use ($request){
            $q->with(['manajemenHasMerk','manajemenHasType' ,'manajemenHasSupplier' ,]);
            
        }, 'kembaliHasTrs'=> function($q) use($request){
            $q->with(['trsHasGedung','trsHasRuangan','trsHasKelompok',]);
            
            
        }, 'kembaliHasPegawai' => function($q){
            $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
        }])
        ->whereHas('kembaliHasTrs', function ($q) use($request){
            $q->when($request->ruangan , function ($q) use ($request) {
                $q->where('trs_ruangan_id',$request->ruangan);
            });
        })
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('pengembalian_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
       ->where('pengembalian_data_id', 3)->get();
       return \view('laporan/pengembalian.atkRuanganExcel', \compact('datakembali'));
    }


         // ATK

    public function inv(Request $request)
    {
        if ($request->all()) {
         $datakembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek', 'kembaliHasPegawai' => function($q){
            $q->with('pegawaiHasBagian');
            $q->with('pegawaiHasSubBagian');
        }, 'kembaliHasKondisiSkrg', 'kembaliHasKondisiSblm'])->where('pengembalian_data_id', 4)
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('pengembalian_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })->get();

        return \view('laporan/pengembalian.inv', \compact('datakembali'));
        }
            $datakembali = [];
            // $gedung = [];
            return \view('laporan/pengembalian.inv', \compact('datakembali'));

    }

    public function kem_inv_excel(Request $request)
    {
        $datakembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek' => function($q){
            $q->with('manajemenHasMerk');
            $q->with('manajemenHasType');
            $q->with('manajemenHasSupplier');
        }, 'kembaliHasTrs'=> function($q) {
            $q->with('trsHasGedung');
            $q->with('trsHasRuangan');
            $q->with('trsHasKelompok');
        }, 'kembaliHasPegawai' => function($q){
            $q->with('pegawaiHasBagian');
            $q->with('pegawaiHasSubBagian');
        }])
       ->where('pengembalian_data_id', 4)->get();

       return \view('laporan/pengembalian.invExcel', \compact('datakembali'));
    }

    public function kem_inv_gedung(Request $request)
    {
        $gedung = GedungModels::get();
        if ($request->all()) {
         $datakembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek' => function($q) use ($request){
            $q->with(['manajemenHasMerk','manajemenHasType' ,'manajemenHasSupplier' ,]);
            
        }, 'kembaliHasTrs'=> function($q) use($request){
            $q->with(['trsHasGedung','trsHasRuangan','trsHasKelompok',]);
            
            
        }, 'kembaliHasPegawai' => function($q){
            $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
        }])
        ->whereHas('kembaliHasTrs', function ($q) use($request){
            $q->when($request->gedung , function ($q) use ($request) {
                $q->where('trs_gedung_id',$request->gedung);
            });
        })
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('pengembalian_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
       ->where('pengembalian_data_id', 4)->get();


        return \view('laporan/pengembalian.invGedung', \compact('datakembali', 'gedung'));
        }
        $datakembali = [];
        // $gedung = [];
        return \view('laporan/pengembalian.invGedung', \compact('datakembali', 'gedung'));

    }

    public function kem_inv_gedung_excel(Request $request)
    {
        // dd($request->all());
        $gedung = GedungModels::get();
        $datakembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek' => function($q) use ($request){
            $q->with(['manajemenHasMerk','manajemenHasType' ,'manajemenHasSupplier' ,]);
            
        }, 'kembaliHasTrs'=> function($q) use($request){
            $q->with(['trsHasGedung','trsHasRuangan','trsHasKelompok',]);
            
            
        }, 'kembaliHasPegawai' => function($q){
            $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
        }])
        ->whereHas('kembaliHasTrs', function ($q) use($request){
            $q->when($request->gedung , function ($q) use ($request) {
                $q->where('trs_gedung_id',$request->gedung);
            });
        })
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('pengembalian_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
       ->where('pengembalian_data_id', 4)->get();
       return \view('laporan/pengembalian.invGedungExcel', \compact('datakembali', 'gedung'));
    }

     public function kem_inv_ruang(Request $request)
    {
        $ruangan = RuanganModels::get();
        if ($request->all()) {
         $datakembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek' => function($q) use ($request){
            $q->with(['manajemenHasMerk','manajemenHasType' ,'manajemenHasSupplier' ,]);
            
        }, 'kembaliHasTrs'=> function($q) use($request){
            $q->with(['trsHasGedung','trsHasRuangan','trsHasKelompok',]);
            
            
        }, 'kembaliHasPegawai' => function($q){
            $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
        }])
        ->whereHas('kembaliHasTrs', function ($q) use($request){
            $q->when($request->ruangan , function ($q) use ($request) {
                $q->where('trs_ruangan_id',$request->ruangan);
            });
        })
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('pengembalian_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
       ->where('pengembalian_data_id', 4)->get();


        return \view('laporan/pengembalian.invRuangan', \compact('datakembali', 'ruangan'));
        }
            $datakembali = [];
            // $gedung = [];
            return \view('laporan/pengembalian.invRuangan', \compact('datakembali', 'ruangan'));

    }

    public function kem_inv_ruang_excel(Request $request)
    {
        // dd($request->all());
        // $ruangan = GedungModels::get();
        $datakembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek' => function($q) use ($request){
            $q->with(['manajemenHasMerk','manajemenHasType' ,'manajemenHasSupplier' ,]);
            
        }, 'kembaliHasTrs'=> function($q) use($request){
            $q->with(['trsHasGedung','trsHasRuangan','trsHasKelompok',]);
            
            
        }, 'kembaliHasPegawai' => function($q){
            $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
        }])
        ->whereHas('kembaliHasTrs', function ($q) use($request){
            $q->when($request->ruangan , function ($q) use ($request) {
                $q->where('trs_ruangan_id',$request->ruangan);
            });
        })
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('pengembalian_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
       ->where('pengembalian_data_id', 4)->get();
       return \view('laporan/pengembalian.invRuanganExcel', \compact('datakembali'));
    }
}
