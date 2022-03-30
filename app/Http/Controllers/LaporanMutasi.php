<?php

namespace App\Http\Controllers;

use App\Models\GedungModels;
use App\Models\MutasiModels;
use Illuminate\Http\Request;
use App\Models\RuanganModels;

class LaporanMutasi extends Controller
{
    public function index(Request $request)
    {
        if ($request->all()) {
        $getMutasi = MutasiModels::with(['MutasiHasPegawai', 'mutasiHasKondisi', 'MutasiHasDetail'=> function($q){
            $q->with('DetailMutasiHasPegawai');
        }, 'MutasiHasBagian', 'MutasiHasSubBagian', 'MutasiHasGedung', 'MutasiHasRuangan'])->where('mutasi_data_id', 1)
        ->when($request->start || $request->end, function ($q) use ($request) {
                    $q->whereBetween('mutasi_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })->get();
        return \view('laporan/mutasi.mutasiPerangkat', \compact('getMutasi'));

        }
            $getMutasi = [];
            return \view('laporan/mutasi.mutasiPerangkat', \compact('getMutasi'));
    }

    public function mut_prangkat_excel(Request $request)
    {
        $getMutasi = MutasiModels::with(['MutasiHasPegawai', 'mutasiHasKondisi', 'MutasiHasDetail'=> function($q){
            $q->with('DetailMutasiHasPegawai');
        }, 'MutasiHasBagian', 'MutasiHasSubBagian', 'MutasiHasGedung', 'MutasiHasRuangan'])->where('mutasi_data_id', 1)
        ->when($request->start || $request->end, function ($q) use ($request) {
                    $q->whereBetween('mutasi_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })->get();
        return \view('laporan/mutasi.mutasiPerangkatExcel', \compact('getMutasi'));
    }


    public function mut_prangkat_gedung(Request $request)
    {
        $gedung = GedungModels::get();
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
        ->get();
        return \view('laporan/mutasi.mutasiPerangkatGedung', \compact('getMutasi', 'gedung'));

        }
            $getMutasi = [];
            return \view('laporan/mutasi.mutasiPerangkatGedung', \compact('getMutasi', 'gedung'));
    }

    public function mut_prangkat_gedung_excel(Request $request)
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
        ->get();
        return \view('laporan/mutasi.mutasiPerangkatGedungExcel', \compact('getMutasi'));
    }

    public function mut_prangkat_ruangan(Request $request)
    {
        $ruangan = RuanganModels::get();
        if ($request->all()) {
        $getMutasi = MutasiModels::with(['MutasiHasPegawai', 'mutasiHasKondisi', 'MutasiHasDetail'=> function($q){
            $q->with('DetailMutasiHasPegawai');
        }, 'MutasiHasBagian', 'MutasiHasSubBagian', 'MutasiHasGedung', 'MutasiHasRuangan'])->where('mutasi_data_id', 1)
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('mutasi_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
        ->when($request->ruangan , function ($q) use ($request) {
            $q->where('mutasi_ruangan_id',$request->ruangan);
                   
        })
        ->get();
        return \view('laporan/mutasi.mutasiPerangkatRuangan', \compact('getMutasi', 'ruangan'));

        }
            $getMutasi = [];
            return \view('laporan/mutasi.mutasiPerangkatRuangan', \compact('getMutasi', 'ruangan'));
    }

    public function mut_prangkat_ruangan_excel(Request $request)
    {
       $getMutasi = MutasiModels::with(['MutasiHasPegawai', 'mutasiHasKondisi', 'MutasiHasDetail'=> function($q){
            $q->with('DetailMutasiHasPegawai');
        }, 'MutasiHasBagian', 'MutasiHasSubBagian', 'MutasiHasGedung', 'MutasiHasRuangan'])->where('mutasi_data_id', 1)
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('mutasi_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
        ->when($request->ruangan , function ($q) use ($request) {
            $q->where('mutasi_ruangan_id',$request->ruangan);
                   
        })
        ->get();
        return \view('laporan/mutasi.mutasiPerangkatRuanganExcel', \compact('getMutasi'));
    }




    // aplikasi
    public function aplikasi(Request $request)
    {
        if ($request->all()) {
        $getMutasi = MutasiModels::with(['MutasiHasPegawai', 'mutasiHasKondisi', 'MutasiHasDetail'=> function($q){
            $q->with('DetailMutasiHasPegawai');
        }, 'MutasiHasBagian', 'MutasiHasSubBagian', 'MutasiHasGedung', 'MutasiHasRuangan'])->where('mutasi_data_id', 2)
        ->when($request->start || $request->end, function ($q) use ($request) {
                    $q->whereBetween('mutasi_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })->get();
        return \view('laporan/mutasi.mutasiAplikasi', \compact('getMutasi'));

        }
            $getMutasi = [];
            return \view('laporan/mutasi.mutasiAplikasi', \compact('getMutasi'));
    }

    public function mut_aplikasi_excel(Request $request)
    {
        $getMutasi = MutasiModels::with(['MutasiHasPegawai', 'mutasiHasKondisi', 'MutasiHasDetail'=> function($q){
            $q->with('DetailMutasiHasPegawai');
        }, 'MutasiHasBagian', 'MutasiHasSubBagian', 'MutasiHasGedung', 'MutasiHasRuangan'])->where('mutasi_data_id', 2)
        ->when($request->start || $request->end, function ($q) use ($request) {
                    $q->whereBetween('mutasi_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })->get();
        return \view('laporan/mutasi.mutasiAplikasiExcel', \compact('getMutasi'));
    }


    public function mut_aplikasi_gedung(Request $request)
    {
        $gedung = GedungModels::get();
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
        ->get();
        return \view('laporan/mutasi.mutasiAplikasiGedung', \compact('getMutasi', 'gedung'));

        }
            $getMutasi = [];
            return \view('laporan/mutasi.mutasiAplikasiGedung', \compact('getMutasi', 'gedung'));
    }

    public function mut_aplikasi_gedung_excel(Request $request)
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
        ->get();
        return \view('laporan/mutasi.mutasiAplikasiGedungExcel', \compact('getMutasi'));
    }

    public function mut_aplikasi_ruangan(Request $request)
    {
        $ruangan = RuanganModels::get();
        if ($request->all()) {
        $getMutasi = MutasiModels::with(['MutasiHasPegawai', 'mutasiHasKondisi', 'MutasiHasDetail'=> function($q){
            $q->with('DetailMutasiHasPegawai');
        }, 'MutasiHasBagian', 'MutasiHasSubBagian', 'MutasiHasGedung', 'MutasiHasRuangan'])->where('mutasi_data_id', 2)
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('mutasi_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
        ->when($request->ruangan , function ($q) use ($request) {
            $q->where('mutasi_ruangan_id',$request->ruangan);
                   
        })
        ->get();
        return \view('laporan/mutasi.mutasiAplikasiRuangan', \compact('getMutasi', 'ruangan'));

        }
            $getMutasi = [];
            return \view('laporan/mutasi.mutasiAplikasiRuangan', \compact('getMutasi', 'ruangan'));
    }

    public function mut_aplikasi_ruangan_excel(Request $request)
    {
       $getMutasi = MutasiModels::with(['MutasiHasPegawai', 'mutasiHasKondisi', 'MutasiHasDetail'=> function($q){
            $q->with('DetailMutasiHasPegawai');
        }, 'MutasiHasBagian', 'MutasiHasSubBagian', 'MutasiHasGedung', 'MutasiHasRuangan'])->where('mutasi_data_id', 2)
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('mutasi_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
        ->when($request->ruangan , function ($q) use ($request) {
            $q->where('mutasi_ruangan_id',$request->ruangan);
                   
        })
        ->get();
        return \view('laporan/mutasi.mutasiAplikasiRuanganExcel', \compact('getMutasi'));
    }


    // aplikasi
    public function AlatKantor(Request $request)
    {
        if ($request->all()) {
        $getMutasi = MutasiModels::with(['MutasiHasPegawai', 'mutasiHasKondisi', 'MutasiHasDetail'=> function($q){
            $q->with('DetailMutasiHasPegawai');
        }, 'MutasiHasBagian', 'MutasiHasSubBagian', 'MutasiHasGedung', 'MutasiHasRuangan'])->where('mutasi_data_id', 3)
        ->when($request->start || $request->end, function ($q) use ($request) {
                    $q->whereBetween('mutasi_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })->get();
        return \view('laporan/mutasi.mutasiAlatKantor', \compact('getMutasi'));

        }
            $getMutasi = [];
            return \view('laporan/mutasi.mutasiAlatKantor', \compact('getMutasi'));
    }

    public function mut_AlatKantor_excel(Request $request)
    {
        $getMutasi = MutasiModels::with(['MutasiHasPegawai', 'mutasiHasKondisi', 'MutasiHasDetail'=> function($q){
            $q->with('DetailMutasiHasPegawai');
        }, 'MutasiHasBagian', 'MutasiHasSubBagian', 'MutasiHasGedung', 'MutasiHasRuangan'])->where('mutasi_data_id', 3)
        ->when($request->start || $request->end, function ($q) use ($request) {
                    $q->whereBetween('mutasi_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })->get();
        return \view('laporan/mutasi.mutasiAlatKantorExcel', \compact('getMutasi'));
    }


    public function mut_AlatKantor_gedung(Request $request)
    {
        $gedung = GedungModels::get();
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
        ->get();
        return \view('laporan/mutasi.mutasiAlatKantorGedung', \compact('getMutasi', 'gedung'));

        }
            $getMutasi = [];
            return \view('laporan/mutasi.mutasiAlatKantorGedung', \compact('getMutasi', 'gedung'));
    }

    public function mut_AlatKantor_gedung_excel(Request $request)
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
        ->get();
        return \view('laporan/mutasi.mutasiAlatKantorGedungExcel', \compact('getMutasi'));
    }

    public function mut_AlatKantor_ruangan(Request $request)
    {
        $ruangan = RuanganModels::get();
        if ($request->all()) {
        $getMutasi = MutasiModels::with(['MutasiHasPegawai', 'mutasiHasKondisi', 'MutasiHasDetail'=> function($q){
            $q->with('DetailMutasiHasPegawai');
        }, 'MutasiHasBagian', 'MutasiHasSubBagian', 'MutasiHasGedung', 'MutasiHasRuangan'])->where('mutasi_data_id', 3)
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('mutasi_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
        ->when($request->ruangan , function ($q) use ($request) {
            $q->where('mutasi_ruangan_id',$request->ruangan);
                   
        })
        ->get();
        return \view('laporan/mutasi.mutasiAlatKantorRuangan', \compact('getMutasi', 'ruangan'));

        }
            $getMutasi = [];
            return \view('laporan/mutasi.mutasiAlatKantorRuangan', \compact('getMutasi', 'ruangan'));
    }

    public function mut_AlatKantor_ruangan_excel(Request $request)
    {
       $getMutasi = MutasiModels::with(['MutasiHasPegawai', 'mutasiHasKondisi', 'MutasiHasDetail'=> function($q){
            $q->with('DetailMutasiHasPegawai');
        }, 'MutasiHasBagian', 'MutasiHasSubBagian', 'MutasiHasGedung', 'MutasiHasRuangan'])->where('mutasi_data_id', 3)
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('mutasi_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
        ->when($request->ruangan , function ($q) use ($request) {
            $q->where('mutasi_ruangan_id',$request->ruangan);
                   
        })
        ->get();
        return \view('laporan/mutasi.mutasiAlatKantorRuanganExcel', \compact('getMutasi'));
    }


    // aplikasi
    public function Inv(Request $request)
    {
        if ($request->all()) {
        $getMutasi = MutasiModels::with(['MutasiHasPegawai', 'mutasiHasKondisi', 'MutasiHasDetail'=> function($q){
            $q->with('DetailMutasiHasPegawai');
        }, 'MutasiHasBagian', 'MutasiHasSubBagian', 'MutasiHasGedung', 'MutasiHasRuangan'])->where('mutasi_data_id', 4)
        ->when($request->start || $request->end, function ($q) use ($request) {
                    $q->whereBetween('mutasi_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })->get();
        return \view('laporan/mutasi.mutasiInv', \compact('getMutasi'));

        }
            $getMutasi = [];
            return \view('laporan/mutasi.mutasiInv', \compact('getMutasi'));
    }

    public function mut_Inv_excel(Request $request)
    {
        $getMutasi = MutasiModels::with(['MutasiHasPegawai', 'mutasiHasKondisi', 'MutasiHasDetail'=> function($q){
            $q->with('DetailMutasiHasPegawai');
        }, 'MutasiHasBagian', 'MutasiHasSubBagian', 'MutasiHasGedung', 'MutasiHasRuangan'])->where('mutasi_data_id', 4)
        ->when($request->start || $request->end, function ($q) use ($request) {
                    $q->whereBetween('mutasi_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })->get();
        return \view('laporan/mutasi.mutasiInvExcel', \compact('getMutasi'));
    }


    public function mut_Inv_gedung(Request $request)
    {
        $gedung = GedungModels::get();
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
        ->get();
        return \view('laporan/mutasi.mutasiInvGedung', \compact('getMutasi', 'gedung'));

        }
            $getMutasi = [];
            return \view('laporan/mutasi.mutasiInvGedung', \compact('getMutasi', 'gedung'));
    }

    public function mut_Inv_gedung_excel(Request $request)
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
        ->get();
        return \view('laporan/mutasi.mutasiInvGedungExcel', \compact('getMutasi'));
    }

    public function mut_Inv_ruangan(Request $request)
    {
        $ruangan = RuanganModels::get();
        if ($request->all()) {
        $getMutasi = MutasiModels::with(['MutasiHasPegawai', 'mutasiHasKondisi', 'MutasiHasDetail'=> function($q){
            $q->with('DetailMutasiHasPegawai');
        }, 'MutasiHasBagian', 'MutasiHasSubBagian', 'MutasiHasGedung', 'MutasiHasRuangan'])->where('mutasi_data_id', 4)
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('mutasi_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
        ->when($request->ruangan , function ($q) use ($request) {
            $q->where('mutasi_ruangan_id',$request->ruangan);
                   
        })
        ->get();
        return \view('laporan/mutasi.mutasiInvRuangan', \compact('getMutasi', 'ruangan'));

        }
            $getMutasi = [];
            return \view('laporan/mutasi.mutasiInvRuangan', \compact('getMutasi', 'ruangan'));
    }

    public function mut_Inv_ruangan_excel(Request $request)
    {
       $getMutasi = MutasiModels::with(['MutasiHasPegawai', 'mutasiHasKondisi', 'MutasiHasDetail'=> function($q){
            $q->with('DetailMutasiHasPegawai');
        }, 'MutasiHasBagian', 'MutasiHasSubBagian', 'MutasiHasGedung', 'MutasiHasRuangan'])->where('mutasi_data_id', 4)
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('mutasi_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })
        ->when($request->ruangan , function ($q) use ($request) {
            $q->where('mutasi_ruangan_id',$request->ruangan);
                   
        })
        ->get();
        return \view('laporan/mutasi.mutasiInvRuanganExcel', \compact('getMutasi'));
    }
}
