<?php

namespace App\Http\Controllers;

use App\Models\GedungModels;
use Illuminate\Http\Request;
use App\Models\KondisiModels;
use App\Models\RuanganModels;
use App\Models\TransaksiDataModel;

class LaporanAlatKantor extends Controller
{
     public function alatKantor(Request $request)
    {
       
        if ($request->all()) {
            $alatKantor = TransaksiDataModel::with(['trsHasData','trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic'])
            ->orderBy('trs_id', 'desc')->where('trs_jenis_id',3)
            ->when($request->start || $request->end, function ($q) use ($request) {
                    $q->whereBetween('trs_date',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
            })->get();

        // dd($alatkantor);

            return \view('laporan/alatkantor.alatkantor', \compact('alatKantor'));
        }
            $alatKantor = [];
            return \view('laporan/alatkantor.alatkantor', \compact('alatKantor'));
    }

    public function alatkantor_excel(Request $request)
    {
        $alatkantor = TransaksiDataModel::with(['trsHasData' => function($q){
            $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi', 'manajemenHasSupplier']);
           
        },'trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic'])
        ->orderBy('trs_id', 'desc')->where('trs_jenis_id',3)
        ->when($request->start || $request->end, function ($q) use ($request) {
                $q->whereBetween('trs_date',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                
        })->get();
        
            return \view('laporan/alatkantor.alatkantorExcel', \compact('alatkantor'));
    }

    public function alatkantorPergedung(Request $request)
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

            return \view('laporan/alatkantor.alatkantorBygedung', \compact('alatkantor', 'gedung'));
        }
            $alatkantor = [];
            // $gedung = [];
            return \view('laporan/alatkantor.alatkantorBygedung', \compact('alatkantor', 'gedung'));
    }

    public function alatkantorPergedung_excel(Request $request)
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
        
            return \view('laporan/alatkantor.alatkantorExcelGedung', \compact('alatkantor'));
    }

    public function alatKantorPerRuangan(Request $request)
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

            return \view('laporan/alatkantor.alatkantorByruangan', \compact('alatkantor', 'ruangan'));
        }
            $alatkantor = [];
            // $ruangan = [];
            return \view('laporan/alatkantor.alatkantorByruangan', \compact('alatkantor', 'ruangan'));
    }

    public function alatkantorPerRuangan_excel(Request $request)
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
        
            return \view('laporan/alatkantor.alatkantorExcelRuangan', \compact('alatkantor'));
    }
    public function alatkantorPerKondisi(Request $request)
    {
        $kondisi = KondisiModels::get();
        if ($request->all()) {
            $alatkantor = TransaksiDataModel::with(['trsHasData','trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic','trsHasGedung','trsHasKondisi'])
            ->orderBy('trs_id', 'desc')->where('trs_jenis_id',3)
            ->when($request->start || $request->end, function ($q) use ($request) {
                    $q->whereBetween('trs_date',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
            })->when($request->kondisi, function ($q) use ($request) {
                $q->where('trs_kondisi_id', '=',  $request->kondisi);
            })
            ->get();

        // dd($alatkantor);

            return \view('laporan/alatkantor.alatkantorBykondisi', \compact('alatkantor', 'kondisi'));
        }
            $alatkantor = [];
            // $kondisi = [];
            return \view('laporan/alatkantor.alatkantorBykondisi', \compact('alatkantor', 'kondisi'));
    }

    public function alatkantorPerKondisi_excel(Request $request)
    {
        $alatkantor = TransaksiDataModel::with(['trsHasData','trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic','trsHasGedung','trsHasKondisi'])
        ->orderBy('trs_id', 'desc')->where('trs_jenis_id',3)
        ->when($request->start || $request->end, function ($q) use ($request) {
                $q->whereBetween('trs_date',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                
        })->when($request->kondisi, function ($q) use ($request) {
            $q->where('trs_kondisi_id', '=',  $request->kondisi);
        })
        ->get();
        
            return \view('laporan/alatkantor.alatkantorExcelKondisi', \compact('alatkantor'));
    }
}
