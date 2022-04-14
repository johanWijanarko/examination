<?php

namespace App\Http\Controllers;

use App\Models\GedungModels;
use App\Models\MutasiModels;
use Illuminate\Http\Request;
use App\Models\RuanganModels;
use App\Models\DetailTransaksi;
use App\Models\TypeKtegoryModels;

class LaporanAllNominatif extends Controller
{
    public function laporanTransaksi(Request $request){
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

    public function laporanPeminjaman(Request $request){
        return view('laporan.laporanPeminjaman');
    }

    public function laporanPengembalian(Request $request){
        return view('laporan.laporanPengembalian');
    }

    public function laporanPerbaikan(Request $request){
        return view('laporan.laporanPerbaikan');
    }
}
