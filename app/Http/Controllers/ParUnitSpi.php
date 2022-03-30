<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParUnitSpiModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class ParUnitSpi extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->cari;
        // dd($cari);
        $unitspi = ParUnitSpiModel::where('unit_spi_del_st', 1)
            ->when($request->cari, function ($q) use ($request) {
                $q->where('unit_spi_nama', 'like', '%' . $request->cari . '%');
            })
            ->paginate(10);
        return view('parameter/par_pegawai/unit_spi.index', compact('unitspi'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }
    public function tambah()
    {
        return view('parameter/par_pegawai/unit_spi.tambah');
    }

    public function save(Request $request)
    {
        // dd($request->all());
        DB::connection()->enableQueryLog();
        $this->validate($request, [
            'jabatan' => 'required',
        ]);

        $save = [
            'unit_spi_nama' => $request->jabatan,
            'unit_spi_del_st' => 1
        ];
        // dd($save);
        $ParUnitSpiModel = ParUnitSpiModel::create($save);
        $keterangan = 'menambahkan jabatan unit spi dengan ID '. $ParUnitSpiModel->unit_spi_id. ', nama '.$request->jabatan;

        $cek = \Log::channel('database')->info($ParUnitSpiModel);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('tambah jabatan unit spi',$keterangan ,json_encode($query ));
        // $this->save_log('tambah jabatan unit spi',$keterangan ,$ParUnitSpiModel );

        Alert::success('Success', 'Data berhasil di Simpan');
        return redirect('parameter/pegawaispi/unitspi');
    }

    public function edit($id)
    {
        $getData = ParUnitSpiModel::where('unit_spi_id', $id)->first();
        // dd($getData);
        return view('parameter/par_pegawai/unit_spi.edit', compact('getData'));
    }

    public function update(Request $request, $id)
    {
        DB::connection()->enableQueryLog();
        $this->validate($request, [
            'jabatan' => 'required',
        ]);

        $update = [
            'unit_spi_nama' => $request->jabatan,
        ];
        $ketspi = ParUnitSpiModel::where('unit_spi_id', $id)->first();
        $ParUnitSpiModel = ParUnitSpiModel::where('unit_spi_id', $id)->update($update);
        $keterangan = 'Update jabatan unit spi dengan ID '. $id. ', dari '.$ketspi->unit_spi_nama. ' menjadi '.$request->jabatan;

        $cek = \Log::channel('database')->info($ParUnitSpiModel);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('Update jabatan unit spi',$keterangan ,json_encode($query ));
        // $this->save_log('Update jabatan unit spi',$keterangan ,$ParUnitSpiModel );

        Alert::success('Success', 'Data berhasil di Update');
        return redirect('parameter/pegawaispi/unitspi');
    }

    public function confrimDel($id)
    {
        $getData = ParUnitSpiModel::where('unit_spi_id', $id)->first();
        return view('parameter/par_pegawai/unit_spi.delete', compact('getData'));
    }

    public function delete($id)
    {
        DB::connection()->enableQueryLog();
        $delete = [
            'unit_spi_del_st' => 0
        ];
        $ParUnitSpiModel = ParUnitSpiModel::where('unit_spi_id', $id)->update($delete);
        $keterangan = 'Delete jabatan unit spi dengan ID '. $id;

        $cek = \Log::channel('database')->info($ParUnitSpiModel);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('Delete jabatan unit spi',$keterangan ,json_encode($query ));
        // $this->save_log('Delete jabatan unit spi',$keterangan ,$ParUnitSpiModel );

        Alert::success('Success', 'Data berhasil di Delete');
        return redirect('parameter/pegawaispi/unitspi');
    }
}
