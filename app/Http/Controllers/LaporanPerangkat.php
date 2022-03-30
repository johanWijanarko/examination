<?php

namespace App\Http\Controllers;

use App\Models\GedungModels;
use Illuminate\Http\Request;
use App\Models\KondisiModels;
use App\Models\RuanganModels;
use App\Models\TransaksiDataModel;

class LaporanPerangkat extends Controller
{
    public function perangkat(Request $request)
    {
       
        if ($request->all()) {
            $lapperangkat = TransaksiDataModel::with(['trsHasData','trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic'])
            ->orderBy('trs_id', 'desc')->where('trs_jenis_id',1)
            ->when($request->start || $request->end, function ($q) use ($request) {
                    $q->whereBetween('trs_date',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
            })->get();

        // dd($lapperangkat);

            return \view('laporan/perangkat.perangkat', \compact('lapperangkat'));
        }
            $lapperangkat = [];
            return \view('laporan/perangkat.perangkat', \compact('lapperangkat'));
    }

    public function perangkat_excel(Request $request)
    {
        $lapperangkat = TransaksiDataModel::with(['trsHasData' => function($q){
            $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi', 'manajemenHasSupplier']);
           
        },'trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic'])
        ->orderBy('trs_id', 'desc')->where('trs_jenis_id',1)
        ->when($request->start || $request->end, function ($q) use ($request) {
                $q->whereBetween('trs_date',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                
        })->get();
        
            return \view('laporan/perangkat.perangkatExcel', \compact('lapperangkat'));
    }

    public function perangkatPergedung(Request $request)
    {
        $gedung = GedungModels::get();
        if ($request->all()) {
            $lapperangkat = TransaksiDataModel::with(['trsHasData','trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic','trsHasGedung'])
            ->orderBy('trs_id', 'desc')->where('trs_jenis_id',1)
            ->when($request->start || $request->end, function ($q) use ($request) {
                    $q->whereBetween('trs_date',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
            })->when($request->gedung, function ($q) use ($request) {
                $q->where('trs_gedung_id', '=',  $request->gedung);
            })
            ->get();

        // dd($lapperangkat);

            return \view('laporan/perangkat.perangkatBygedung', \compact('lapperangkat', 'gedung'));
        }
            $lapperangkat = [];
            // $gedung = [];
            return \view('laporan/perangkat.perangkatBygedung', \compact('lapperangkat', 'gedung'));
    }

    public function perangkatPergedung_excel(Request $request)
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
        
            return \view('laporan/perangkat.perangkatExcelGedung', \compact('lapperangkat'));
    }

    public function perangkatPerRuangan(Request $request)
    {
        $ruangan = RuanganModels::get();
        if ($request->all()) {
            $lapperangkat = TransaksiDataModel::with(['trsHasData','trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic','trsHasGedung'])
            ->orderBy('trs_id', 'desc')->where('trs_jenis_id',1)
            ->when($request->start || $request->end, function ($q) use ($request) {
                    $q->whereBetween('trs_date',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
            })->when($request->ruangan, function ($q) use ($request) {
                $q->where('trs_ruangan_id', '=',  $request->ruangan);
            })
            ->get();

        // dd($lapperangkat);

            return \view('laporan/perangkat.perangkatByruangan', \compact('lapperangkat', 'ruangan'));
        }
            $lapperangkat = [];
            // $ruangan = [];
            return \view('laporan/perangkat.perangkatByruangan', \compact('lapperangkat', 'ruangan'));
    }

    public function perangkatPerRuangan_excel(Request $request)
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
        
            return \view('laporan/perangkat.perangkatExcelRuangan', \compact('lapperangkat'));
    }
    public function perangkatPerKondisi(Request $request)
    {
        $kondisi = KondisiModels::get();
        if ($request->all()) {
            $lapperangkat = TransaksiDataModel::with(['trsHasData','trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic','trsHasGedung','trsHasKondisi'])
            ->orderBy('trs_id', 'desc')->where('trs_jenis_id',1)
            ->when($request->start || $request->end, function ($q) use ($request) {
                    $q->whereBetween('trs_date',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
            })->when($request->kondisi, function ($q) use ($request) {
                $q->where('trs_kondisi_id', '=',  $request->kondisi);
            })
            ->get();

        // dd($lapperangkat);

            return \view('laporan/perangkat.perangkatBykondisi', \compact('lapperangkat', 'kondisi'));
        }
            $lapperangkat = [];
            // $kondisi = [];
            return \view('laporan/perangkat.perangkatBykondisi', \compact('lapperangkat', 'kondisi'));
    }

    public function perangkatPerKondisi_excel(Request $request)
    {
        $lapperangkat = TransaksiDataModel::with(['trsHasData','trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic','trsHasGedung','trsHasKondisi'])
        ->orderBy('trs_id', 'desc')->where('trs_jenis_id',1)
        ->when($request->start || $request->end, function ($q) use ($request) {
                $q->whereBetween('trs_date',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                
        })->when($request->kondisi, function ($q) use ($request) {
            $q->where('trs_kondisi_id', '=',  $request->kondisi);
        })
        ->get();
        
            return \view('laporan/perangkat.perangkatExcelKondisi', \compact('lapperangkat'));
    }

}
