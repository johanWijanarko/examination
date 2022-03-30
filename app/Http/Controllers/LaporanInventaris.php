<?php

namespace App\Http\Controllers;

use App\Models\GedungModels;
use Illuminate\Http\Request;
use App\Models\KondisiModels;
use App\Models\RuanganModels;
use App\Models\TransaksiDataModel;

class LaporanInventaris extends Controller
{
         public function inventaris(Request $request)
    {
       
        if ($request->all()) {
            $inventaris = TransaksiDataModel::with(['trsHasData','trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic'])
            ->orderBy('trs_id', 'desc')->where('trs_jenis_id',4)
            ->when($request->start || $request->end, function ($q) use ($request) {
                    $q->whereBetween('trs_date',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
            })->get();

        // dd($inventaris);

            return \view('laporan/inventaris.inventaris', \compact('inventaris'));
        }
            $inventaris = [];
            return \view('laporan/inventaris.inventaris', \compact('inventaris'));
    }

    public function inventaris_excel(Request $request)
    {
        $inventaris = TransaksiDataModel::with(['trsHasData' => function($q){
            $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi', 'manajemenHasSupplier']);
           
        },'trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic'])
        ->orderBy('trs_id', 'desc')->where('trs_jenis_id',4)
        ->when($request->start || $request->end, function ($q) use ($request) {
                $q->whereBetween('trs_date',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                
        })->get();
        
            return \view('laporan/inventaris.inventarisExcel', \compact('inventaris'));
    }

    public function inventarisPergedung(Request $request)
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

            return \view('laporan/inventaris.inventarisBygedung', \compact('inventaris', 'gedung'));
        }
            $inventaris = [];
            // $gedung = [];
            return \view('laporan/inventaris.inventarisBygedung', \compact('inventaris', 'gedung'));
    }

    public function inventarisPergedung_excel(Request $request)
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
        
            return \view('laporan/inventaris.inventarisExcelGedung', \compact('inventaris'));
    }

    public function inventarisPerRuangan(Request $request)
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

            return \view('laporan/inventaris.inventarisByruangan', \compact('inventaris', 'ruangan'));
        }
            $inventaris = [];
            // $ruangan = [];
            return \view('laporan/inventaris.inventarisByruangan', \compact('inventaris', 'ruangan'));
    }

    public function inventarisPerRuangan_excel(Request $request)
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
        
            return \view('laporan/inventaris.inventarisExcelRuangan', \compact('inventaris'));
    }
    public function inventarisPerKondisi(Request $request)
    {
        $kondisi = KondisiModels::get();
        if ($request->all()) {
            $inventaris = TransaksiDataModel::with(['trsHasData','trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic','trsHasGedung','trsHasKondisi'])
            ->orderBy('trs_id', 'desc')->where('trs_jenis_id',4)
            ->when($request->start || $request->end, function ($q) use ($request) {
                    $q->whereBetween('trs_date',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
            })->when($request->kondisi, function ($q) use ($request) {
                $q->where('trs_kondisi_id', '=',  $request->kondisi);
            })
            ->get();

        // dd($inventaris);

            return \view('laporan/inventaris.inventarisBykondisi', \compact('inventaris', 'kondisi'));
        }
            $inventaris = [];
            // $kondisi = [];
            return \view('laporan/inventaris.inventarisBykondisi', \compact('inventaris', 'kondisi'));
    }

    public function inventarisPerKondisi_excel(Request $request)
    {
        $inventaris = TransaksiDataModel::with(['trsHasData','trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic','trsHasGedung','trsHasKondisi'])
        ->orderBy('trs_id', 'desc')->where('trs_jenis_id',4)
        ->when($request->start || $request->end, function ($q) use ($request) {
                $q->whereBetween('trs_date',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                
        })->when($request->kondisi, function ($q) use ($request) {
            $q->where('trs_kondisi_id', '=',  $request->kondisi);
        })
        ->get();
        
            return \view('laporan/inventaris.inventarisExcelKondisi', \compact('inventaris'));
    }
}
