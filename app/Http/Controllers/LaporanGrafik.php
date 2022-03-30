<?php

namespace App\Http\Controllers;

use App\Models\MutasiModels;
use Illuminate\Http\Request;
use App\Models\PengembalianModels;
use App\Models\TransaksiDataModel;

class LaporanGrafik extends Controller
{
    public function grafik_prkt_gedung(Request $request)
    {
        $countPerangkatGedung = TransaksiDataModel::with(['trsHasData' => function($q){
            $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi', 'manajemenHasSupplier']);
            },
            'trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic' ,'trsHasGedung', 'trsHasRuangan', 'trsHasKondisi'])
            ->orderBy('trs_id', 'desc')->where('trs_jenis_id',1)
        ->count();
        return view('laporan/grafik.prangkatgedung', compact('countPerangkatGedung'));
    }

    public function grafik_prkt_ruang(Request $request)
    {
        $countPerangkatRuang = TransaksiDataModel::with(['trsHasData' => function($q){
            $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi', 'manajemenHasSupplier']);
            },
            'trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic' ,'trsHasGedung', 'trsHasRuangan', 'trsHasKondisi'])
            ->orderBy('trs_id', 'desc')->where('trs_jenis_id',1)
        ->count();
        return view('laporan/grafik.grafikPrktRuang', compact('countPerangkatRuang'));
    }


    public function grafik_apl_gedung(Request $request)
    {
        $countAplGedung = TransaksiDataModel::with(['trsHasData' => function($q){
            $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi', 'manajemenHasSupplier']);
            },
            'trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic' ,'trsHasGedung', 'trsHasRuangan', 'trsHasKondisi'])
            ->orderBy('trs_id', 'desc')->where('trs_jenis_id',2)
        ->count();
        return view('laporan/grafik.grafikAplGedung', compact('countAplGedung'));
    }

    public function grafik_apl_ruang(Request $request)
    {
        $countAplRuang = TransaksiDataModel::with(['trsHasData' => function($q){
            $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi', 'manajemenHasSupplier']);
            },
            'trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic' ,'trsHasGedung', 'trsHasRuangan', 'trsHasKondisi'])
            ->orderBy('trs_id', 'desc')->where('trs_jenis_id',2)
        ->count();
        return view('laporan/grafik.grafikAplRuang', compact('countAplRuang'));
    }


    public function grafik_atk_gedung(Request $request)
    {
        $countAtkGedung = TransaksiDataModel::with(['trsHasData' => function($q){
            $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi', 'manajemenHasSupplier']);
            },
            'trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic' ,'trsHasGedung', 'trsHasRuangan', 'trsHasKondisi'])
            ->orderBy('trs_id', 'desc')->where('trs_jenis_id',3)
        ->count();
        return view('laporan/grafik.grafikAtkGedung', compact('countAtkGedung'));
    }

    public function grafik_atk_ruang(Request $request)
    {
        $countAtkRuang = TransaksiDataModel::with(['trsHasData' => function($q){
            $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi', 'manajemenHasSupplier']);
            },
            'trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic' ,'trsHasGedung', 'trsHasRuangan', 'trsHasKondisi'])
            ->orderBy('trs_id', 'desc')->where('trs_jenis_id',3)
        ->count();
        return view('laporan/grafik.grafikAtkRuang', compact('countAtkRuang'));
    }

     public function grafik_inv_gedung(Request $request)
    {
        $countInvGedung = TransaksiDataModel::with(['trsHasData' => function($q){
            $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi', 'manajemenHasSupplier']);
            },
            'trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic' ,'trsHasGedung', 'trsHasRuangan', 'trsHasKondisi'])
            ->orderBy('trs_id', 'desc')->where('trs_jenis_id',4)
        ->count();
        return view('laporan/grafik.grafikInvGedung', compact('countInvGedung'));
    }

    public function grafik_inv_ruang(Request $request)
    {
        $countAplRuang = TransaksiDataModel::with(['trsHasData' => function($q){
            $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi', 'manajemenHasSupplier']);
            },
            'trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic' ,'trsHasGedung', 'trsHasRuangan', 'trsHasKondisi'])
            ->orderBy('trs_id', 'desc')->where('trs_jenis_id',4)
        ->count();
        return view('laporan/grafik.grafikInvRuang', compact('countAplRuang'));
    }
     public function grafik_mut_prkt(Request $request)
     {
        $getMutasiperangkat = MutasiModels::with(['MutasiHasPegawai', 'mutasiHasKondisi', 'MutasiHasDetail'=> function($q){
                $q->with('DetailMutasiHasPegawai');
            }, 'MutasiHasBagian', 'MutasiHasSubBagian', 'MutasiHasGedung', 'MutasiHasRuangan'])->where('mutasi_data_id', 1)
            ->when($request->start || $request->end, function ($q) use ($request) {
                $q->whereBetween('mutasi_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
            })
        ->count();
        return view('laporan/grafik.grafikMutPrkt', compact('getMutasiperangkat'));
     }

      public function grafik_mut_apl(Request $request)
     {
        $getMutasiAplikasi = MutasiModels::with(['MutasiHasPegawai', 'mutasiHasKondisi', 'MutasiHasDetail'=> function($q){
                $q->with('DetailMutasiHasPegawai');
            }, 'MutasiHasBagian', 'MutasiHasSubBagian', 'MutasiHasGedung', 'MutasiHasRuangan'])->where('mutasi_data_id', 2)
            ->when($request->start || $request->end, function ($q) use ($request) {
                        $q->whereBetween('mutasi_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                    
            })
        ->count();
        return view('laporan/grafik.grafikMutApl', compact('getMutasiAplikasi'));
     }

      public function grafik_mut_atk(Request $request)
     {
        $getMutasiAtk = MutasiModels::with(['MutasiHasPegawai', 'mutasiHasKondisi', 'MutasiHasDetail'=> function($q){
            $q->with('DetailMutasiHasPegawai');
            }, 'MutasiHasBagian', 'MutasiHasSubBagian', 'MutasiHasGedung', 'MutasiHasRuangan'])->where('mutasi_data_id', 3)
            ->when($request->start || $request->end, function ($q) use ($request) {
                    $q->whereBetween('mutasi_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })->count();
        return view('laporan/grafik.grafikMutAtk', compact('getMutasiAtk'));
       
     }

      public function grafik_mut_inv(Request $request)
     {
        $getMutasiInv = MutasiModels::with(['MutasiHasPegawai', 'mutasiHasKondisi', 'MutasiHasDetail'=> function($q){
            $q->with('DetailMutasiHasPegawai');
            }, 'MutasiHasBagian', 'MutasiHasSubBagian', 'MutasiHasGedung', 'MutasiHasRuangan'])->where('mutasi_data_id', 4)
            ->when($request->start || $request->end, function ($q) use ($request) {
                        $q->whereBetween('mutasi_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })->count();
        return view('laporan/grafik.grafikMutInv', compact('getMutasiInv'));
     }

    public function grafik_kembali_prkt(Request $request)
     {
        $kembali_prkt = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek', 'kembaliHasPegawai' => function($q){
            $q->with('pegawaiHasBagian');
            $q->with('pegawaiHasSubBagian');
        }, 'kembaliHasKondisiSkrg', 'kembaliHasKondisiSblm'])->where('pengembalian_data_id', 1)
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('pengembalian_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })->count();
        return view('laporan/grafik.grafikKemPrkt', compact('kembali_prkt'));
        
     }

     public function grafik_kembali_apl(Request $request)
     {
        $kembali_apl = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek', 'kembaliHasPegawai' => function($q){
            $q->with('pegawaiHasBagian');
            $q->with('pegawaiHasSubBagian');
        }, 'kembaliHasKondisiSkrg', 'kembaliHasKondisiSblm'])->where('pengembalian_data_id', 2)
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('pengembalian_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })->count();
        return view('laporan/grafik.grafikKemApl', compact('kembali_apl'));
     }

     public function grafik_kembali_atk(Request $request)
     {
        $kembali_atk = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek', 'kembaliHasPegawai' => function($q){
            $q->with('pegawaiHasBagian');
            $q->with('pegawaiHasSubBagian');
        }, 'kembaliHasKondisiSkrg', 'kembaliHasKondisiSblm'])->where('pengembalian_data_id', 3)
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('pengembalian_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })->count();

        return view('laporan/grafik.grafikKemAtk', compact('kembali_atk'));
     }

     public function grafik_kembali_inv(Request $request)
     {
        $kembali_inv = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek', 'kembaliHasPegawai' => function($q){    
            $q->with('pegawaiHasBagian');
            $q->with('pegawaiHasSubBagian');
        }, 'kembaliHasKondisiSkrg', 'kembaliHasKondisiSblm'])->where('pengembalian_data_id', 4)
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('pengembalian_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })->count();

        return view('laporan/grafik.grafikKemInv', compact('kembali_inv'));
     }
   
}
