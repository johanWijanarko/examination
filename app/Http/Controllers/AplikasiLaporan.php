<?php

namespace App\Http\Controllers;

use App\Models\GedungModels;
use Illuminate\Http\Request;
use App\Models\KondisiModels;
use App\Models\RuanganModels;
use App\Models\TransaksiDataModel;

class AplikasiLaporan extends Controller
{
    public function aplikasi(Request $request)
    {
       
        if ($request->all()) {
            $aplikasi = TransaksiDataModel::with(['trsHasData','trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic'])
            ->orderBy('trs_id', 'desc')->where('trs_jenis_id',2)
            ->when($request->start || $request->end, function ($q) use ($request) {
                    $q->whereBetween('trs_date',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
            })->get();

        // dd($aplikasi);

            return \view('laporan/aplikasi.aplikasi', \compact('aplikasi'));
        }
            $aplikasi = [];
            return \view('laporan/aplikasi.aplikasi', \compact('aplikasi'));
    }

    public function aplikasi_excel(Request $request)
    {
        $aplikasi = TransaksiDataModel::with(['trsHasData' => function($q){
            $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi', 'manajemenHasSupplier']);
           
        },'trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic'])
        ->orderBy('trs_id', 'desc')->where('trs_jenis_id',2)
        ->when($request->start || $request->end, function ($q) use ($request) {
                $q->whereBetween('trs_date',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                
        })->get();
        
            return \view('laporan/aplikasi.aplikasiExcel', \compact('aplikasi'));
    }

    public function aplikasiPergedung(Request $request)
    {
        $gedung = GedungModels::get();
        if ($request->all()) {
            $aplikasi = TransaksiDataModel::with(['trsHasData','trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic','trsHasGedung'])
            ->orderBy('trs_id', 'desc')->where('trs_jenis_id',2)
            ->when($request->start || $request->end, function ($q) use ($request) {
                    $q->whereBetween('trs_date',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
            })->when($request->gedung, function ($q) use ($request) {
                $q->where('trs_gedung_id', '=',  $request->gedung);
            })
            ->get();

        // dd($aplikasi);

            return \view('laporan/aplikasi.aplikasiBygedung', \compact('aplikasi', 'gedung'));
        }
            $aplikasi = [];
            // $gedung = [];
            return \view('laporan/aplikasi.aplikasiBygedung', \compact('aplikasi', 'gedung'));
    }

    public function aplikasiPergedung_excel(Request $request)
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
        
            return \view('laporan/aplikasi.aplikasiExcelGedung', \compact('aplikasi'));
    }

    public function aplikasiPerRuangan(Request $request)
    {
        $ruangan = RuanganModels::get();
        if ($request->all()) {
            $aplikasi = TransaksiDataModel::with(['trsHasData','trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic','trsHasGedung'])
            ->orderBy('trs_id', 'desc')->where('trs_jenis_id',2)
            ->when($request->start || $request->end, function ($q) use ($request) {
                    $q->whereBetween('trs_date',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
            })->when($request->ruangan, function ($q) use ($request) {
                $q->where('trs_ruangan_id', '=',  $request->ruangan);
            })
            ->get();

        // dd($aplikasi);

            return \view('laporan/aplikasi.aplikasiByruangan', \compact('aplikasi', 'ruangan'));
        }
            $aplikasi = [];
            // $ruangan = [];
            return \view('laporan/aplikasi.aplikasiByruangan', \compact('aplikasi', 'ruangan'));
    }

    public function aplikasiPerRuangan_excel(Request $request)
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
        
            return \view('laporan/aplikasi.aplikasiExcelRuangan', \compact('aplikasi'));
    }
    public function aplikasiPerKondisi(Request $request)
    {
        $kondisi = KondisiModels::get();
        if ($request->all()) {
            $aplikasi = TransaksiDataModel::with(['trsHasData','trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic','trsHasGedung','trsHasKondisi'])
            ->orderBy('trs_id', 'desc')->where('trs_jenis_id',2)
            ->when($request->start || $request->end, function ($q) use ($request) {
                    $q->whereBetween('trs_date',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
            })->when($request->kondisi, function ($q) use ($request) {
                $q->where('trs_kondisi_id', '=',  $request->kondisi);
            })
            ->get();

        // dd($aplikasi);

            return \view('laporan/aplikasi.aplikasiBykondisi', \compact('aplikasi', 'kondisi'));
        }
            $aplikasi = [];
            // $kondisi = [];
            return \view('laporan/aplikasi.aplikasiBykondisi', \compact('aplikasi', 'kondisi'));
    }

    public function aplikasiPerKondisi_excel(Request $request)
    {
        $aplikasi = TransaksiDataModel::with(['trsHasData','trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic','trsHasGedung','trsHasKondisi'])
        ->orderBy('trs_id', 'desc')->where('trs_jenis_id',2)
        ->when($request->start || $request->end, function ($q) use ($request) {
                $q->whereBetween('trs_date',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                
        })->when($request->kondisi, function ($q) use ($request) {
            $q->where('trs_kondisi_id', '=',  $request->kondisi);
        })
        ->get();
        
            return \view('laporan/aplikasi.aplikasiExcelKondisi', \compact('aplikasi'));
    }
}
