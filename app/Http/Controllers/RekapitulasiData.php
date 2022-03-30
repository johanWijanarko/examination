<?php

namespace App\Http\Controllers;

use App\Models\GedungModels;
use App\Models\MutasiModels;
use Illuminate\Http\Request;
use App\Models\RuanganModels;
use App\Models\PengembalianModels;
use App\Models\TransaksiDataModel;

class RekapitulasiData extends Controller
{
    public function rekapPerangkatGedung(Request $request)
    {

        $gedung = GedungModels::get();

        if ($request->all()) {

            $lapperangkat = TransaksiDataModel::with(['trsHasData' => function($q){
                $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi', 'manajemenHasSupplier']);
            
            },'trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic' ,'trsHasGedung', 'trsHasRuangan', 'trsHasKondisi'])
            ->orderBy('trs_id', 'desc')->where('trs_jenis_id',1)
            ->when($request->start || $request->end, function ($q) use ($request) {
                $q->whereBetween('trs_date',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
            })
            ->when($request->gedung, function ($q) use ($request) {
                    $q->where('trs_gedung_id', '=',  $request->gedung);
                })
            ->get();
            return \view('laporan/rekapitulasi.perangkatBygedung', \compact('lapperangkat', 'gedung'));
        }
            $lapperangkat = [];
            return \view('laporan/rekapitulasi.perangkatBygedung', \compact('lapperangkat', 'gedung'));
    }


    public function rekapPerangkatGedungExcel(Request $request)
    {

        $lapperangkat = TransaksiDataModel::with(['trsHasData' => function($q){
            $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi', 'manajemenHasSupplier']);
        
        },'trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic' ,'trsHasGedung', 'trsHasRuangan', 'trsHasKondisi'])
        ->orderBy('trs_id', 'desc')->where('trs_jenis_id',1)
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('trs_date',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
        })
        ->when($request->gedung, function ($q) use ($request) {
                $q->where('trs_gedung_id', '=',  $request->gedung);
            })
        ->get();
        return \view('laporan/rekapitulasi.perangkatExcelGedung', \compact('lapperangkat'));
    
    }

    public function rekapPerangkatRuang(Request $request)
    {
        $ruangan = RuanganModels::get();

        if ($request->all()) {

            $lapperangkat = TransaksiDataModel::with(['trsHasData' => function($q){
                $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi', 'manajemenHasSupplier']);
            
            },'trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic' ,'trsHasGedung', 'trsHasRuangan', 'trsHasKondisi'])
            ->orderBy('trs_id', 'desc')->where('trs_jenis_id',1)
            ->when($request->start || $request->end, function ($q) use ($request) {
                $q->whereBetween('trs_date',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
            })
            ->when($request->ruangan, function ($q) use ($request) {
                $q->where('trs_ruangan_id', '=',  $request->ruangan);
            })
            ->get();
            return \view('laporan/rekapitulasi.perangkatRuang', \compact('lapperangkat', 'ruangan'));
        }
            $lapperangkat = [];
            return \view('laporan/rekapitulasi.perangkatRuang', \compact('lapperangkat', 'ruangan'));
    }


    public function rekapPerangkatRuangExcel(Request $request)
    {
        $lapperangkat = TransaksiDataModel::with(['trsHasData' => function($q){
            $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi', 'manajemenHasSupplier']);
        
        },'trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic' ,'trsHasGedung', 'trsHasRuangan', 'trsHasKondisi'])
        ->orderBy('trs_id', 'desc')->where('trs_jenis_id',1)
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('trs_date',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
        })
        ->when($request->ruangan, function ($q) use ($request) {
            $q->where('trs_ruangan_id', '=',  $request->ruangan);
        })
        ->get();
        return \view('laporan/rekapitulasi.perangkatRuangExcel', \compact('lapperangkat'));
        
    }


    public function rekapAplGedung(Request $request)
    {
        $gedung = GedungModels::get();
        if ($request->all()) {
             $aplikasi = TransaksiDataModel::with(['trsHasData' => function($q){
                $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi', 'manajemenHasSupplier']);
           
                },'trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic' ,'trsHasGedung', 'trsHasRuangan', 'trsHasKondisi'])
                ->orderBy('trs_id', 'desc')->where('trs_jenis_id',2)
                ->when($request->start || $request->end, function ($q) use ($request) {
                    $q->whereBetween('trs_date',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                })
                ->when($request->gedung, function ($q) use ($request) {
                        $q->where('trs_gedung_id', '=',  $request->gedung);
                    })
                ->get();

            return \view('laporan/rekapitulasi.aplikasiGedung', \compact('aplikasi', 'gedung'));
        }
            $aplikasi = [];
            // $gedung = [];
            return \view('laporan/rekapitulasi.aplikasiGedung', \compact('aplikasi', 'gedung'));
    }

    public function rekapAplGedungExcel(Request $request)
    {
        $aplikasi = TransaksiDataModel::with(['trsHasData' => function($q){
            $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi', 'manajemenHasSupplier']);
           
        },'trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic' ,'trsHasGedung', 'trsHasRuangan', 'trsHasKondisi'])
        ->orderBy('trs_id', 'desc')->where('trs_jenis_id',2)
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('trs_date',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
        })
        ->when($request->gedung, function ($q) use ($request) {
                $q->where('trs_gedung_id', '=',  $request->gedung);
            })
        ->get();
        
            return \view('laporan/rekapitulasi.aplikasiGedungExcel', \compact('aplikasi'));
    }

    public function rekapAplRuang(Request $request)
    {
        $ruangan = RuanganModels::get();
        if ($request->all()) {
            $aplikasi = TransaksiDataModel::with(['trsHasData' => function($q){
                $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi', 'manajemenHasSupplier']);
           
            },'trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic' ,'trsHasGedung', 'trsHasRuangan', 'trsHasKondisi'])
                ->orderBy('trs_id', 'desc')->where('trs_jenis_id',2)
                ->when($request->start || $request->end, function ($q) use ($request) {
                $q->whereBetween('trs_date',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
            })
                ->when($request->ruangan, function ($q) use ($request) {
                    $q->where('trs_ruangan_id', '=',  $request->ruangan);
                })
            ->get();

            return \view('laporan/rekapitulasi.aplikasiRuangan', \compact('aplikasi', 'ruangan'));
        }
            $aplikasi = [];
            // $ruangan = [];
            return \view('laporan/rekapitulasi.aplikasiRuangan', \compact('aplikasi', 'ruangan'));
    }

    public function rekapAplRuangExcel(Request $request)
    {

        $aplikasi = TransaksiDataModel::with(['trsHasData' => function($q){
            $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi', 'manajemenHasSupplier']);
           
        },'trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic' ,'trsHasGedung', 'trsHasRuangan', 'trsHasKondisi'])
        ->orderBy('trs_id', 'desc')->where('trs_jenis_id',2)
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('trs_date',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
        })
        ->when($request->ruangan, function ($q) use ($request) {
                $q->where('trs_ruangan_id', '=',  $request->ruangan);
            })
        ->get();
        
            return \view('laporan/rekapitulasi.aplikasiRuanganExcel', \compact('aplikasi'));
    }

    public function rekapAtkGedung(Request $request)
    {
        $gedung = GedungModels::get();
        if ($request->all()) {
            $alatkantor = TransaksiDataModel::with(['trsHasData','trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic','trsHasGedung'])
            ->orderBy('trs_id', 'desc')->where('trs_jenis_id',3)
            ->when($request->start || $request->end, function ($q) use ($request) {
                    $q->whereBetween('trs_date',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
            })->when($request->gedung, function ($q) use ($request) {
                $q->where('trs_gedung_id', '=',  $request->gedung);
            })
            ->get();

        // dd($alatkantor);

            return \view('laporan/rekapitulasi.alatkantorGedung', \compact('alatkantor', 'gedung'));
        }
            $alatkantor = [];
            // $gedung = [];
            return \view('laporan/rekapitulasi.alatkantorGedung', \compact('alatkantor', 'gedung'));
    }

    public function rekapAtkGedungExcel(Request $request)
    {
        $alatkantor = TransaksiDataModel::with(['trsHasData' => function($q){
            $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi', 'manajemenHasSupplier']);
           
        },'trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic' ,'trsHasGedung', 'trsHasRuangan', 'trsHasKondisi'])
        ->orderBy('trs_id', 'desc')->where('trs_jenis_id',3)
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('trs_date',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
        })
        ->when($request->gedung, function ($q) use ($request) {
                $q->where('trs_gedung_id', '=',  $request->gedung);
            })
        ->get();
        
            return \view('laporan/rekapitulasi.alatkantorGedungExcel', \compact('alatkantor'));
    }

    public function rekapAtkRuang(Request $request)
    {
        $ruangan = RuanganModels::get();
        if ($request->all()) {
            $alatkantor = TransaksiDataModel::with(['trsHasData','trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic','trsHasGedung'])
            ->orderBy('trs_id', 'desc')->where('trs_jenis_id',3)
            ->when($request->start || $request->end, function ($q) use ($request) {
                    $q->whereBetween('trs_date',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
            })->when($request->ruangan, function ($q) use ($request) {
                $q->where('trs_ruangan_id', '=',  $request->ruangan);
            })
            ->get();

        // dd($alatkantor);

            return \view('laporan/rekapitulasi.alatkantorRuangan', \compact('alatkantor', 'ruangan'));
        }
            $alatkantor = [];
            // $ruangan = [];
            return \view('laporan/rekapitulasi.alatkantorRuangan', \compact('alatkantor', 'ruangan'));
    }

    public function rekapAtkRuangExcel(Request $request)
    {

        $alatkantor = TransaksiDataModel::with(['trsHasData' => function($q){
            $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi', 'manajemenHasSupplier']);
           
        },'trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic' ,'trsHasGedung', 'trsHasRuangan', 'trsHasKondisi'])
        ->orderBy('trs_id', 'desc')->where('trs_jenis_id',3)
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('trs_date',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
        })
        ->when($request->ruangan, function ($q) use ($request) {
                $q->where('trs_ruangan_id', '=',  $request->ruangan);
            })
        ->get();
        
            return \view('laporan/rekapitulasi.alatkantorRuanganExcel', \compact('alatkantor'));
        
    }



    public function rekapInvGedung(Request $request)
    {
        $gedung = GedungModels::get();
        if ($request->all()) {
            $inventaris = TransaksiDataModel::with(['trsHasData','trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic','trsHasGedung'])
            ->orderBy('trs_id', 'desc')->where('trs_jenis_id',4)
            ->when($request->start || $request->end, function ($q) use ($request) {
                    $q->whereBetween('trs_date',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
            })->when($request->gedung, function ($q) use ($request) {
                $q->where('trs_gedung_id', '=',  $request->gedung);
            })
            ->get();

        // dd($inventaris);

            return \view('laporan/rekapitulasi.inventarisGedung', \compact('inventaris', 'gedung'));
        }
            $inventaris = [];
            // $gedung = [];
            return \view('laporan/rekapitulasi.inventarisGedung', \compact('inventaris', 'gedung'));
    }

    public function rekapInvGedungExcel(Request $request)
    {
        $inventaris = TransaksiDataModel::with(['trsHasData' => function($q){
            $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi', 'manajemenHasSupplier']);
           
        },'trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic' ,'trsHasGedung', 'trsHasRuangan', 'trsHasKondisi'])
        ->orderBy('trs_id', 'desc')->where('trs_jenis_id',4)
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('trs_date',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
        })
        ->when($request->gedung, function ($q) use ($request) {
                $q->where('trs_gedung_id', '=',  $request->gedung);
            })
        ->get();
        
            return \view('laporan/rekapitulasi.inventarisGedungExcel', \compact('inventaris'));
    }

    public function rekapInvRuang(Request $request)
    {
        $ruangan = RuanganModels::get();
        if ($request->all()) {
            $inventaris = TransaksiDataModel::with(['trsHasData','trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic','trsHasGedung'])
            ->orderBy('trs_id', 'desc')->where('trs_jenis_id',4)
            ->when($request->start || $request->end, function ($q) use ($request) {
                    $q->whereBetween('trs_date',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
            })->when($request->ruangan, function ($q) use ($request) {
                $q->where('trs_ruangan_id', '=',  $request->ruangan);
            })
            ->get();

        // dd($inventaris);

            return \view('laporan/rekapitulasi.inventarisRuangan', \compact('inventaris', 'ruangan'));
        }
            $inventaris = [];
            // $ruangan = [];
            return \view('laporan/rekapitulasi.inventarisRuangan', \compact('inventaris', 'ruangan'));
    }

    public function rekapInvRuangExcel(Request $request)
    {

        $inventaris = TransaksiDataModel::with(['trsHasData' => function($q){
            $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi', 'manajemenHasSupplier']);
           
        },'trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic' ,'trsHasGedung', 'trsHasRuangan', 'trsHasKondisi'])
        ->orderBy('trs_id', 'desc')->where('trs_jenis_id',4)
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('trs_date',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
        })
        ->when($request->ruangan, function ($q) use ($request) {
                $q->where('trs_ruangan_id', '=',  $request->ruangan);
            })
        ->get();
        
            return \view('laporan/rekapitulasi.inventarisRuanganExcel', \compact('inventaris'));
    }


    public function mutasiperangkat(Request $request)
    {
        $gedung = GedungModels::get();
        $ruangan = RuanganModels::get();
        if ($request->all()) {
        $getMutasi = MutasiModels::with(['MutasiHasPegawai', 'mutasiHasKondisi', 'MutasiHasDetail'=> function($q){
            $q->with('DetailMutasiHasPegawai');
        }, 'MutasiHasBagian', 'MutasiHasSubBagian', 'MutasiHasGedung', 'MutasiHasRuangan'])->where('mutasi_data_id', 1)
        ->when($request->start || $request->end, function ($q) use ($request) {
                    $q->whereBetween('mutasi_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
        ->when($request->gedung , function ($q) use ($request) {
            $q->where('mutasi_gedung_id',$request->gedung);
                   
        })
        ->when($request->ruangan , function ($q) use ($request) {
            $q->where('mutasi_ruangan_id',$request->ruangan);
                   
        })
        ->get();
        return \view('laporan/rekapitulasi.mutasiPerangkat', \compact('getMutasi', 'gedung', 'ruangan'));

        }
            $getMutasi = [];
            return \view('laporan/rekapitulasi.mutasiPerangkat', \compact('getMutasi', 'gedung', 'ruangan'));
    }

    public function mutasiperangkatExcel(Request $request)
    {
        $getMutasi = MutasiModels::with(['MutasiHasPegawai', 'mutasiHasKondisi', 'MutasiHasDetail'=> function($q){
            $q->with('DetailMutasiHasPegawai');
        }, 'MutasiHasBagian', 'MutasiHasSubBagian', 'MutasiHasGedung', 'MutasiHasRuangan'])->where('mutasi_data_id', 1)
        ->when($request->start || $request->end, function ($q) use ($request) {
                    $q->whereBetween('mutasi_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
         ->when($request->gedung , function ($q) use ($request) {
            $q->where('mutasi_gedung_id',$request->gedung);
                   
        })
        ->when($request->ruangan , function ($q) use ($request) {
            $q->where('mutasi_ruangan_id',$request->ruangan);
                   
        })
        ->get();
        return \view('laporan/rekapitulasi.mutasiPerangkatExcel', \compact('getMutasi'));
    }



    public function mutasiaplikasi(Request $request)
    {
        $gedung = GedungModels::get();
        $ruangan = RuanganModels::get();
        if ($request->all()) {
        $getMutasi = MutasiModels::with(['MutasiHasPegawai', 'mutasiHasKondisi', 'MutasiHasDetail'=> function($q){
            $q->with('DetailMutasiHasPegawai');
        }, 'MutasiHasBagian', 'MutasiHasSubBagian', 'MutasiHasGedung', 'MutasiHasRuangan'])->where('mutasi_data_id', 2)
        ->when($request->start || $request->end, function ($q) use ($request) {
                    $q->whereBetween('mutasi_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
         ->when($request->gedung , function ($q) use ($request) {
            $q->where('mutasi_gedung_id',$request->gedung);
                   
        })
        ->when($request->ruangan , function ($q) use ($request) {
            $q->where('mutasi_ruangan_id',$request->ruangan);
                   
        })
        ->get();
        return \view('laporan/rekapitulasi.mutasiAplikasi', \compact('getMutasi', 'gedung', 'ruangan'));

        }
            $getMutasi = [];
            return \view('laporan/rekapitulasi.mutasiAplikasi', \compact('getMutasi', 'gedung', 'ruangan'));
    }

    public function mutasiaplikasiExcel(Request $request)
    {
        $getMutasi = MutasiModels::with(['MutasiHasPegawai', 'mutasiHasKondisi', 'MutasiHasDetail'=> function($q){
            $q->with('DetailMutasiHasPegawai');
        }, 'MutasiHasBagian', 'MutasiHasSubBagian', 'MutasiHasGedung', 'MutasiHasRuangan'])->where('mutasi_data_id', 2)
        ->when($request->start || $request->end, function ($q) use ($request) {
                    $q->whereBetween('mutasi_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
         ->when($request->gedung , function ($q) use ($request) {
            $q->where('mutasi_gedung_id',$request->gedung);
                   
        })
        ->when($request->ruangan , function ($q) use ($request) {
            $q->where('mutasi_ruangan_id',$request->ruangan);
                   
        })
        ->get();
        return \view('laporan/rekapitulasi.mutasiAplikasiExcel', \compact('getMutasi'));
    }

     // aplikasi
    public function mutasiatk(Request $request)
    {
        $gedung = GedungModels::get();
        $ruangan = RuanganModels::get();
        if ($request->all()) {
        $getMutasi = MutasiModels::with(['MutasiHasPegawai', 'mutasiHasKondisi', 'MutasiHasDetail'=> function($q){
            $q->with('DetailMutasiHasPegawai');
        }, 'MutasiHasBagian', 'MutasiHasSubBagian', 'MutasiHasGedung', 'MutasiHasRuangan'])->where('mutasi_data_id', 3)
        ->when($request->start || $request->end, function ($q) use ($request) {
                    $q->whereBetween('mutasi_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
         ->when($request->gedung , function ($q) use ($request) {
            $q->where('mutasi_gedung_id',$request->gedung);
                   
        })
        ->when($request->ruangan , function ($q) use ($request) {
            $q->where('mutasi_ruangan_id',$request->ruangan);
                   
        })
        ->get();
        return \view('laporan/rekapitulasi.mutasiAlatKantor', \compact('getMutasi', 'gedung', 'ruangan'));

        }
            $getMutasi = [];
            return \view('laporan/rekapitulasi.mutasiAlatKantor', \compact('getMutasi', 'gedung', 'ruangan'));
    }

     public function mutasiatkExcel(Request $request)
    {
        $getMutasi = MutasiModels::with(['MutasiHasPegawai', 'mutasiHasKondisi', 'MutasiHasDetail'=> function($q){
            $q->with('DetailMutasiHasPegawai');
        }, 'MutasiHasBagian', 'MutasiHasSubBagian', 'MutasiHasGedung', 'MutasiHasRuangan'])->where('mutasi_data_id', 3)
        ->when($request->start || $request->end, function ($q) use ($request) {
                    $q->whereBetween('mutasi_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
         ->when($request->gedung , function ($q) use ($request) {
            $q->where('mutasi_gedung_id',$request->gedung);
                   
        })
        ->when($request->ruangan , function ($q) use ($request) {
            $q->where('mutasi_ruangan_id',$request->ruangan);
                   
        })
        ->get();
        return \view('laporan/rekapitulasi.mutasiAlatKantorExcel', \compact('getMutasi'));
    }



    // aplikasi
    public function mutasiInv(Request $request)
    {
        $gedung = GedungModels::get();
        $ruangan = RuanganModels::get();
        if ($request->all()) {
        $getMutasi = MutasiModels::with(['MutasiHasPegawai', 'mutasiHasKondisi', 'MutasiHasDetail'=> function($q){
            $q->with('DetailMutasiHasPegawai');
        }, 'MutasiHasBagian', 'MutasiHasSubBagian', 'MutasiHasGedung', 'MutasiHasRuangan'])->where('mutasi_data_id', 4)
        ->when($request->start || $request->end, function ($q) use ($request) {
                    $q->whereBetween('mutasi_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
         ->when($request->gedung , function ($q) use ($request) {
            $q->where('mutasi_gedung_id',$request->gedung);
                   
        })
        ->when($request->ruangan , function ($q) use ($request) {
            $q->where('mutasi_ruangan_id',$request->ruangan);
                   
        })
        ->get();
        return \view('laporan/rekapitulasi.mutasiInv', \compact('getMutasi', 'gedung', 'ruangan'));

        }
            $getMutasi = [];
            return \view('laporan/rekapitulasi.mutasiInv', \compact('getMutasi', 'gedung', 'ruangan'));
    }

    public function mutasiInvExcel(Request $request)
    {
        $getMutasi = MutasiModels::with(['MutasiHasPegawai', 'mutasiHasKondisi', 'MutasiHasDetail'=> function($q){
            $q->with('DetailMutasiHasPegawai');
        }, 'MutasiHasBagian', 'MutasiHasSubBagian', 'MutasiHasGedung', 'MutasiHasRuangan'])->where('mutasi_data_id', 4)
        ->when($request->start || $request->end, function ($q) use ($request) {
                    $q->whereBetween('mutasi_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
         ->when($request->gedung , function ($q) use ($request) {
            $q->where('mutasi_gedung_id',$request->gedung);
                   
        })
        ->when($request->ruangan , function ($q) use ($request) {
            $q->where('mutasi_ruangan_id',$request->ruangan);
                   
        })
        ->get();
        return \view('laporan/rekapitulasi.mutasiInvExcel', \compact('getMutasi'));
    }


    public function kem_prangkat_perangkat(Request $request)
    {
        $gedung = GedungModels::get();
        $ruangan = RuanganModels::get();
        if ($request->all()) {
        $datakembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek', 'kembaliHasPegawai' => function($q){
            $q->with('pegawaiHasBagian');
            $q->with('pegawaiHasSubBagian');
        }, 'kembaliHasKondisiSkrg', 'kembaliHasKondisiSblm', 'kembaliHasTrs'])->where('pengembalian_data_id', 1)
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('pengembalian_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
        ->whereHas('kembaliHasTrs', function ($q) use($request){
            $q->when($request->ruangan ||  $request->gedung, function ($q) use ($request) {
                $q->where('trs_ruangan_id',$request->ruangan);
                $q->orWhere('trs_gedung_id',$request->gedung);
            });
        })
        ->get();

        return \view('laporan/rekapitulasi.kembaliPerangkatGedung', \compact('datakembali', 'gedung', 'ruangan'));
        }
            $datakembali = [];
            // $gedung = [];
            return \view('laporan/rekapitulasi.kembaliPerangkatGedung', \compact('datakembali', 'gedung', 'ruangan'));

    }

    public function kem_prangkat_excel(Request $request)
    {
       $datakembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek', 'kembaliHasPegawai' => function($q){
            $q->with('pegawaiHasBagian');
            $q->with('pegawaiHasSubBagian');
        }, 'kembaliHasKondisiSkrg', 'kembaliHasKondisiSblm', 'kembaliHasTrs'])->where('pengembalian_data_id', 1)
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('pengembalian_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
        ->whereHas('kembaliHasTrs', function ($q) use($request){
            $q->when($request->ruangan ||  $request->gedung, function ($q) use ($request) {
                $q->where('trs_ruangan_id',$request->ruangan);
                $q->orWhere('trs_gedung_id',$request->gedung);
            });
        })
        ->get();

       return \view('laporan/rekapitulasi.kembaliPerangkatGedungExcel', \compact('datakembali'));
    }

    public function rekap_kem_aplikasi(Request $request)
    {
        $gedung = GedungModels::get();
        $ruangan = RuanganModels::get();
        if ($request->all()) {
        $datakembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek', 'kembaliHasPegawai' => function($q){
            $q->with('pegawaiHasBagian');
            $q->with('pegawaiHasSubBagian');
        }, 'kembaliHasKondisiSkrg', 'kembaliHasKondisiSblm'])->where('pengembalian_data_id', 2)
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('pengembalian_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
        ->whereHas('kembaliHasTrs', function ($q) use($request){
            $q->when($request->ruangan ||  $request->gedung, function ($q) use ($request) {
                $q->where('trs_ruangan_id',$request->ruangan);
                $q->orWhere('trs_gedung_id',$request->gedung);
            });
        })->get();

        return \view('laporan/rekapitulasi.kembaliAplikasi', \compact('datakembali', 'gedung', 'ruangan'));
        }
            $datakembali = [];
            // $gedung = [];
            return \view('laporan/rekapitulasi.kembaliAplikasi', \compact('datakembali', 'gedung', 'ruangan'));

    }

    public function rekap_kem_aplikasi_excel(Request $request)
    {
        $datakembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek', 'kembaliHasPegawai' => function($q){
            $q->with('pegawaiHasBagian');
            $q->with('pegawaiHasSubBagian');
        }, 'kembaliHasKondisiSkrg', 'kembaliHasKondisiSblm'])->where('pengembalian_data_id', 2)
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('pengembalian_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
        ->whereHas('kembaliHasTrs', function ($q) use($request){
            $q->when($request->ruangan ||  $request->gedung, function ($q) use ($request) {
                $q->where('trs_ruangan_id',$request->ruangan);
                $q->orWhere('trs_gedung_id',$request->gedung);
            });
        })->get();

       return \view('laporan/rekapitulasi.kembaliAplikasiExcel', \compact('datakembali'));
    }


    public function rekap_kem_atk(Request $request)
    {
        $gedung = GedungModels::get();
        $ruangan = RuanganModels::get();
        if ($request->all()) {
        $datakembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek', 'kembaliHasPegawai' => function($q){
            $q->with('pegawaiHasBagian');
            $q->with('pegawaiHasSubBagian');
        }, 'kembaliHasKondisiSkrg', 'kembaliHasKondisiSblm'])->where('pengembalian_data_id', 3)
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('pengembalian_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
        ->whereHas('kembaliHasTrs', function ($q) use($request){
            $q->when($request->ruangan ||  $request->gedung, function ($q) use ($request) {
                $q->where('trs_ruangan_id',$request->ruangan);
                $q->orWhere('trs_gedung_id',$request->gedung);
            });
        })->get();

        return \view('laporan/rekapitulasi.kembaliAtk', \compact('datakembali', 'gedung', 'ruangan'));
        }
            $datakembali = [];
            // $gedung = [];
            return \view('laporan/rekapitulasi.kembaliAtk', \compact('datakembali', 'gedung', 'ruangan'));

    }

    public function rekap_kem_atkExcel(Request $request)
    {
        $datakembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek', 'kembaliHasPegawai' => function($q){
            $q->with('pegawaiHasBagian');
            $q->with('pegawaiHasSubBagian');
        }, 'kembaliHasKondisiSkrg', 'kembaliHasKondisiSblm'])->where('pengembalian_data_id', 3)
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('pengembalian_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
        ->whereHas('kembaliHasTrs', function ($q) use($request){
            $q->when($request->ruangan ||  $request->gedung, function ($q) use ($request) {
                $q->where('trs_ruangan_id',$request->ruangan);
                $q->orWhere('trs_gedung_id',$request->gedung);
            });
        })->get();

       return \view('laporan/rekapitulasi.kembaliAtkExcel', \compact('datakembali'));
    }

    public function rekap_kem_inv(Request $request)
    {
        $gedung = GedungModels::get();
        $ruangan = RuanganModels::get();
        if ($request->all()) {
        $datakembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek', 'kembaliHasPegawai' => function($q){
            $q->with('pegawaiHasBagian');
            $q->with('pegawaiHasSubBagian');
        }, 'kembaliHasKondisiSkrg', 'kembaliHasKondisiSblm'])->where('pengembalian_data_id', 4)
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('pengembalian_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
        ->whereHas('kembaliHasTrs', function ($q) use($request){
            $q->when($request->ruangan ||  $request->gedung, function ($q) use ($request) {
                $q->where('trs_ruangan_id',$request->ruangan);
                $q->orWhere('trs_gedung_id',$request->gedung);
            });
        })->get();

        return \view('laporan/rekapitulasi.kembaliInv', \compact('datakembali', 'gedung', 'ruangan'));
        }
            $datakembali = [];
            // $gedung = [];
            return \view('laporan/rekapitulasi.kembaliInv', \compact('datakembali', 'gedung', 'ruangan'));

    }

    public function rekap_kem_invExcel(Request $request)
    {
        $datakembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek', 'kembaliHasPegawai' => function($q){
            $q->with('pegawaiHasBagian');
            $q->with('pegawaiHasSubBagian');
        }, 'kembaliHasKondisiSkrg', 'kembaliHasKondisiSblm'])->where('pengembalian_data_id', 4)
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('pengembalian_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
        ->whereHas('kembaliHasTrs', function ($q) use($request){
            $q->when($request->ruangan ||  $request->gedung, function ($q) use ($request) {
                $q->where('trs_ruangan_id',$request->ruangan);
                $q->orWhere('trs_gedung_id',$request->gedung);
            });
        })->get();

       return \view('laporan/rekapitulasi.kembaliInvExcel', \compact('datakembali'));
    }
}
