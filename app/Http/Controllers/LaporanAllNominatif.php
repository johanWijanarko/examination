<?php

namespace App\Http\Controllers;

use App\Models\GedungModels;
use App\Models\MutasiModels;
use Illuminate\Http\Request;
use App\Models\RuanganModels;
use App\Models\DetailTransaksi;
use App\Models\PeminjamanModels;
use App\Models\TypeKtegoryModels;
use App\Models\PengembalianModels;

class LaporanAllNominatif extends Controller
{
    public function laporanTransaksi(Request $request)
    {
        $type = TypeKtegoryModels::get();
        $ruangan = RuanganModels::get();
        $gedung = GedungModels::get();
        if ($request->all()) {
            $laporan = DetailTransaksi::with(['trsHasStok2' => function($q){
                $q->with(['stokHasType']);
            }, 'trsHasPegawai2' => function ($q){
                $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
            }, 'mainTransaksi'])
            ->whereHas('trsHasStok2', function ($q) use ($request) {
                $q->whereHas('stokHasType', function ($q) use ($request) {
                    $q->when($request->type, function ($q) use ($request) {
                        $q->where('data_type_id', $request->type);
                    });
                });
            })
            ->when($request->start || $request->end, function ($q) use ($request) {
                $q->whereBetween('trs_detail_date',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
            })
            ->when($request->ruangan, function ($q) use ($request) {
                $q->where('trs_detail_ruangan_id', $request->ruangan);
            })
            ->when($request->gedung, function ($q) use ($request) {
                $q->where('trs_detail_gedung_id', $request->gedung);
            })
            ->when($request->status, function ($q) use ($request) {
                $q->where('trs_detail_status', $request->status);
            })
            ->get();
            return view('laporan.laporanTransaksi', compact('laporan', 'type', 'ruangan', 'gedung'));
        }
        $laporan=[];
        return view('laporan.laporanTransaksi', compact('laporan', 'type', 'ruangan', 'gedung'));

        // dd($laporan);
    }

    public function laporanTransaksiExcel(Request $request){
        $type = TypeKtegoryModels::get();
        $ruangan = RuanganModels::get();
        $gedung = GedungModels::get();

            $laporan = DetailTransaksi::with([ 'trsHasGedung', 'trsHasRuangan','trsHasStok2' => function($q){
                $q->with(['stokHasType']);
            }, 'trsHasPegawai2' => function ($q){
                $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
            }, 'mainTransaksi'])
            ->whereHas('trsHasStok2', function ($q) use ($request) {
                $q->whereHas('stokHasType', function ($q) use ($request) {
                    $q->when($request->type, function ($q) use ($request) {
                        $q->where('data_type_id', $request->type);
                    });
                });
            })
            ->when($request->start || $request->end, function ($q) use ($request) {
                $q->whereBetween('trs_detail_date',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
            })
            ->when($request->ruangan, function ($q) use ($request) {
                $q->where('trs_detail_ruangan_id', $request->ruangan);
            })
            ->when($request->gedung, function ($q) use ($request) {
                $q->where('trs_detail_gedung_id', $request->gedung);
            })
            ->when($request->status, function ($q) use ($request) {
                $q->where('trs_detail_status', $request->status);
            })
            ->get();
            // dd($laporan);
        return view('laporan.laporanTransaksiExcel',compact('laporan', 'type', 'ruangan', 'gedung'));
    }

    public function laporanMutasi(Request $request){
        $type = TypeKtegoryModels::get();
        $ruangan = RuanganModels::get();
        $gedung = GedungModels::get();
        if ($request->all()) {
            $getMutasi = MutasiModels::with(['MutasiHasPegawai'=>function ($q){
                $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
            }, 'mutasiHasKondisi', 'MutasiHasDetail'=> function($q){
                $q->with(['DetailMutasiHasPegawai'=> function ($q){
                    $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
                }]);
            }, 'MutasiHasGedung', 'MutasiHasRuangan', 'MutasiHasType'])
            ->when($request->start || $request->end, function ($q) use ($request) {
                $q->whereBetween('mutasi_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
            })
            ->when($request->ruangan, function ($q) use ($request) {
                $q->where('mutasi_ruangan_id', $request->ruangan);
            })
            ->when($request->gedung, function ($q) use ($request) {
                $q->where('mutasi_gedung_id', $request->gedung);
            })
            ->when($request->type, function ($q) use ($request) {
                $q->where('mutasi_data_id', $request->type);
            })
            ->get();
            return view('laporan.laporanMutasi', compact('getMutasi', 'type', 'ruangan', 'gedung'));
        }
            $getMutasi=[];
            return view('laporan.laporanMutasi', compact('getMutasi', 'type', 'ruangan', 'gedung'));
    }

    public function laporanMutasiExcel(Request $request)
    {
        $getMutasi = MutasiModels::with(['MutasiHasPegawai'=>function ($q){
            $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
        }, 'mutasiHasKondisi', 'MutasiHasDetail'=> function($q){
            $q->with(['DetailMutasiHasPegawai'=> function ($q){
                $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
            }]);
        }, 'MutasiHasGedung', 'MutasiHasRuangan', 'MutasiHasType'])
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('mutasi_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
        })
        ->when($request->ruangan, function ($q) use ($request) {
            $q->where('mutasi_ruangan_id', $request->ruangan);
        })
        ->when($request->gedung, function ($q) use ($request) {
            $q->where('mutasi_gedung_id', $request->gedung);
        })
        ->when($request->type, function ($q) use ($request) {
            $q->where('mutasi_data_id', $request->type);
        })
        ->get();
        return view('laporan.laporanMutasiExcel', compact('getMutasi'));
    }
    public function laporanPeminjaman(Request $request){
        $type = TypeKtegoryModels::get();
        $ruangan = RuanganModels::get();
        $gedung = GedungModels::get();
        if ($request->all()) {
            $getDataPinjaman = PeminjamanModels::with(['peminjamanHasObjek', 'peminjamanHasPegawai' =>function ($q){
                $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
            }, 'peminjamanHasGedung', 'peminjamanHasRuangan', 'peminjamanHasType'])->orderBy('peminjaman_id', 'desc')
            ->when($request->start || $request->end, function ($q) use ($request) {
                $q->whereBetween('peminjaman_tanggal',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
            })
            ->when($request->ruangan, function ($q) use ($request) {
                $q->where('peminjaman_ruangan_id', $request->ruangan);
            })
            ->when($request->gedung, function ($q) use ($request) {
                $q->where('peminjaman_gedung_id', $request->gedung);
            })
            ->when($request->type, function ($q) use ($request) {
                $q->where('peminjamanType', $request->type);
            })
            ->when($request->type, function ($q) use ($request) {
                $q->where('peminjamanType', $request->type);
            })
            ->get();
            return view('laporan.laporanPeminjaman', compact('getDataPinjaman', 'type', 'ruangan', 'gedung'));
        }
        $getDataPinjaman=[];
        return view('laporan.laporanPeminjaman', compact('getDataPinjaman', 'type', 'ruangan', 'gedung'));
        // dd($getDataPinjaman);
    }

    public function laporanPeminjamanExcel(Request $request)
    {
        $getDataPinjaman = PeminjamanModels::with(['peminjamanHasObjek', 'peminjamanHasPegawai' =>function ($q){
            $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
        }, 'peminjamanHasGedung', 'peminjamanHasRuangan', 'peminjamanHasType'])->orderBy('peminjaman_id', 'desc')
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('peminjaman_tanggal',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
        })
        ->when($request->ruangan, function ($q) use ($request) {
            $q->where('peminjaman_ruangan_id', $request->ruangan);
        })
        ->when($request->gedung, function ($q) use ($request) {
            $q->where('peminjaman_gedung_id', $request->gedung);
        })
        ->when($request->type, function ($q) use ($request) {
            $q->where('peminjamanType', $request->type);
        })
        ->get();
        return view('laporan.laporanPeminjamanExcel', compact('getDataPinjaman'));
    }
    public function laporanPengembalian(Request $request){
        $type = TypeKtegoryModels::get();
        if ($request->all()) {
            $datakembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek', 'kembaliHasPegawai' => function($q){
                $q->with('pegawaiHasBagian');
                $q->with('pegawaiHasSubBagian');
            }, 'kembaliHasKondisiSkrg', 'kembaliHasKondisiSblm'])
            ->when($request->start || $request->end, function ($q) use ($request) {
                $q->whereBetween('pengembalian_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
            })
            ->when($request->type, function ($q) use ($request) {
                $q->where('pengembalian_data_id', $request->type);
            })
            ->get();
            return view('laporan.laporanPengembalian', compact('datakembali', 'type'));
        }
        $datakembali=[];
        return view('laporan.laporanPengembalian', compact('datakembali', 'type'));

    }

    public function laporanPengembalianExcel(Request $request)
    {
        $datakembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek', 'kembaliHasPegawai' => function($q){
            $q->with('pegawaiHasBagian');
            $q->with('pegawaiHasSubBagian');
        }, 'kembaliHasKondisiSkrg', 'kembaliHasKondisiSblm'])
        ->when($request->start || $request->end, function ($q) use ($request) {
            $q->whereBetween('pengembalian_tgl',[ date('Y-m-d',strtotime($request->start)) , date('Y-m-d',strtotime($request->end))]);
        })
        ->when($request->type, function ($q) use ($request) {
            $q->where('pengembalian_data_id', $request->type);
        })
        ->get();
        return view('laporan.laporanPengembalianExcel', compact('datakembali'));
    }
    public function laporanPerbaikan(Request $request){
        return view('laporan.laporanPerbaikan');
    }
}
