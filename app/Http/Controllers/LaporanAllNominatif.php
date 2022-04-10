<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanAllNominatif extends Controller
{
    public function laporanTransaksi(Request $request){
        return view('laporan.laporanTransaksi');
    }

    public function laporanMutasi(Request $request){
        return view('laporan.laporanMutasi');
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
