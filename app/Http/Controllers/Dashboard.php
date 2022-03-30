<?php

namespace App\Http\Controllers;

use App\Helpers\SiteHelpers;
use App\Models\MutasiModels;
use Illuminate\Http\Request;
use App\Models\PegawaiModels;
use App\Models\AuditAssignModel;
use App\Models\PengembalianModels;
use App\Models\TransaksiDataModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Dashboard extends Controller
{
    public function index(Request $request)
    { 
        $title_page = "Dashboard";
        $label      = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
       
        $countPerangkat = TransaksiDataModel::with(['trsHasData' => function($q){
                $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi', 'manajemenHasSupplier']);
            },
            'trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic' ,'trsHasGedung', 'trsHasRuangan', 'trsHasKondisi'])
            ->orderBy('trs_id', 'desc')->where('trs_jenis_id',1)
        ->count();

        $countPerangkatGedung = TransaksiDataModel::with(['trsHasData' => function($q){
                $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi', 'manajemenHasSupplier']);
            },
            'trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic' ,'trsHasGedung', 'trsHasRuangan', 'trsHasKondisi'])
            ->orderBy('trs_id', 'desc')->where('trs_jenis_id',1)
        ->count();

        $countPerangkatRuang = TransaksiDataModel::with(['trsHasData' => function($q){
                $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi', 'manajemenHasSupplier']);
            },
            'trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic' ,'trsHasGedung', 'trsHasRuangan', 'trsHasKondisi'])
            ->orderBy('trs_id', 'desc')->where('trs_jenis_id',1)
        ->count();

        $countAplikasi = TransaksiDataModel::with(['trsHasData' => function($q){
                $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi', 'manajemenHasSupplier']);
            },
            'trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic' ,'trsHasGedung', 'trsHasRuangan', 'trsHasKondisi'])
            ->orderBy('trs_id', 'desc')->where('trs_jenis_id',2)
        ->count();

        $countAplikasiGedung = TransaksiDataModel::with(['trsHasData' => function($q){
                $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi', 'manajemenHasSupplier']);
            },
            'trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic' ,'trsHasGedung', 'trsHasRuangan', 'trsHasKondisi'])
            ->orderBy('trs_id', 'desc')->where('trs_jenis_id',2)
        ->count();
        $countAplikasiRuang = TransaksiDataModel::with(['trsHasData' => function($q){
                $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi', 'manajemenHasSupplier']);
            },
            'trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic' ,'trsHasGedung', 'trsHasRuangan', 'trsHasKondisi'])
            ->orderBy('trs_id', 'desc')->where('trs_jenis_id',2)
        ->count();

        $countAtk = TransaksiDataModel::with(['trsHasData' => function($q){
                $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi', 'manajemenHasSupplier']);
            },
            'trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic' ,'trsHasGedung', 'trsHasRuangan', 'trsHasKondisi'])
            ->orderBy('trs_id', 'desc')->where('trs_jenis_id',3)
        ->count();

        $countAtkGedung = TransaksiDataModel::with(['trsHasData' => function($q){
                $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi', 'manajemenHasSupplier']);
            },
            'trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic' ,'trsHasGedung', 'trsHasRuangan', 'trsHasKondisi'])
            ->orderBy('trs_id', 'desc')->where('trs_jenis_id',3)
        ->count();

        $countAtkRuang = TransaksiDataModel::with(['trsHasData' => function($q){
                $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi', 'manajemenHasSupplier']);
            },
            'trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic' ,'trsHasGedung', 'trsHasRuangan', 'trsHasKondisi'])
            ->orderBy('trs_id', 'desc')->where('trs_jenis_id',3)
        ->count();
        
        $countInv = TransaksiDataModel::with(['trsHasData' => function($q){
            $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi', 'manajemenHasSupplier']);
            },'trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic' ,'trsHasGedung', 'trsHasRuangan', 'trsHasKondisi'])
            ->orderBy('trs_id', 'desc')->where('trs_jenis_id',4)
        ->count();

        $countInvgedung = TransaksiDataModel::with(['trsHasData' => function($q){
            $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi', 'manajemenHasSupplier']);
            },'trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic' ,'trsHasGedung', 'trsHasRuangan', 'trsHasKondisi'])
            ->orderBy('trs_id', 'desc')->where('trs_jenis_id',4)
        ->count();

        $countInvruang = TransaksiDataModel::with(['trsHasData' => function($q){
            $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi', 'manajemenHasSupplier']);
            },'trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic' ,'trsHasGedung', 'trsHasRuangan', 'trsHasKondisi'])
            ->orderBy('trs_id', 'desc')->where('trs_jenis_id',4)
        ->count();
            
            
        //mutasi 
        $getMutasiperangkat = MutasiModels::with(['MutasiHasPegawai', 'mutasiHasKondisi', 'MutasiHasDetail'=> function($q){
                $q->with('DetailMutasiHasPegawai');
            }, 'MutasiHasBagian', 'MutasiHasSubBagian', 'MutasiHasGedung', 'MutasiHasRuangan'])->where('mutasi_data_id', 1)
            ->when($request->start || $request->end, function ($q) use ($request) {
                $q->whereBetween('mutasi_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
            })
        ->count();
            
        $getMutasiAplikasi = MutasiModels::with(['MutasiHasPegawai', 'mutasiHasKondisi', 'MutasiHasDetail'=> function($q){
                $q->with('DetailMutasiHasPegawai');
            }, 'MutasiHasBagian', 'MutasiHasSubBagian', 'MutasiHasGedung', 'MutasiHasRuangan'])->where('mutasi_data_id', 2)
            ->when($request->start || $request->end, function ($q) use ($request) {
                        $q->whereBetween('mutasi_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                    
            })
        ->count();


        $getMutasiAtk = MutasiModels::with(['MutasiHasPegawai', 'mutasiHasKondisi', 'MutasiHasDetail'=> function($q){
            $q->with('DetailMutasiHasPegawai');
            }, 'MutasiHasBagian', 'MutasiHasSubBagian', 'MutasiHasGedung', 'MutasiHasRuangan'])->where('mutasi_data_id', 3)
            ->when($request->start || $request->end, function ($q) use ($request) {
                    $q->whereBetween('mutasi_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })->count();

        $getMutasiInv = MutasiModels::with(['MutasiHasPegawai', 'mutasiHasKondisi', 'MutasiHasDetail'=> function($q){
            $q->with('DetailMutasiHasPegawai');
            }, 'MutasiHasBagian', 'MutasiHasSubBagian', 'MutasiHasGedung', 'MutasiHasRuangan'])->where('mutasi_data_id', 4)
            ->when($request->start || $request->end, function ($q) use ($request) {
                        $q->whereBetween('mutasi_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                   
        })->count();

        $perangkatkembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek', 'kembaliHasPegawai' => function($q){
                $q->with('pegawaiHasBagian');
                $q->with('pegawaiHasSubBagian');
            }, 'kembaliHasKondisiSkrg', 'kembaliHasKondisiSblm'])->where('pengembalian_data_id', 1)
            ->when($request->start || $request->end, function ($q) use ($request) {
                $q->whereBetween('pengembalian_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                    
            })
        ->count();

        $aplikasikembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek', 'kembaliHasPegawai' => function($q){
                $q->with('pegawaiHasBagian');
                $q->with('pegawaiHasSubBagian');
            }, 'kembaliHasKondisiSkrg', 'kembaliHasKondisiSblm'])->where('pengembalian_data_id', 2)
            ->when($request->start || $request->end, function ($q) use ($request) {
                $q->whereBetween('pengembalian_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                    
            })
        ->count();

        $atkkembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek', 'kembaliHasPegawai' => function($q){
                $q->with('pegawaiHasBagian');
                $q->with('pegawaiHasSubBagian');
            }, 'kembaliHasKondisiSkrg', 'kembaliHasKondisiSblm'])->where('pengembalian_data_id', 3)
            ->when($request->start || $request->end, function ($q) use ($request) {
                $q->whereBetween('pengembalian_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                    
            })
        ->count();

         $invkembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek', 'kembaliHasPegawai' => function($q){
                $q->with('pegawaiHasBagian');
                $q->with('pegawaiHasSubBagian');
            }, 'kembaliHasKondisiSkrg', 'kembaliHasKondisiSblm'])->where('pengembalian_data_id', 4)
            ->when($request->start || $request->end, function ($q) use ($request) {
                $q->whereBetween('pengembalian_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
                    
            })
        ->count();
        return view('admin.index',compact('title_page', 'label', 'countPerangkat','countPerangkatGedung','countPerangkatRuang', 'countAplikasi','countAplikasiGedung', 'countAplikasiRuang','countAtk','countAtkGedung', 'countAtkRuang','countInv', 'countInvgedung', 'countInvruang', 'getMutasiperangkat', 'getMutasiAplikasi', 'getMutasiAtk', 'getMutasiInv', 'perangkatkembali', 'aplikasikembali', 'atkkembali', 'invkembali'));
    }

    
}
