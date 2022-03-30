<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParTahunModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class ParTahun extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->cari;
        $Tahun = ParTahunModel::where('status', 1)
            ->when($request->cari, function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->cari . '%');
            })->orderBy('id_tahun', 'asc')
            ->paginate(10);

        return view('parameter/par_audit/par_tahun.index', compact('Tahun'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }
    public function tambah()
    {
        return view('parameter/par_audit/par_tahun.tambah');
    }

    public function save(Request $request)
    {
        DB::connection()->enableQueryLog();
        // dd($request->all());
        $this->validate($request, [
            'tahun' => 'required|numeric'
        ]);
        $save = [

            'nama' => $request->tahun,
            'status' => 1
        ];
        // dd($save);
        $ParTahunModel = ParTahunModel::create($save);

        $cek = \Log::channel('database')->info($ParTahunModel);
        $query = DB::getQueryLog();
        $query = end($query);

        $keterangan = 'menambahkan Tahun dengan ID '. $ParTahunModel->id_tahun. ', nama '.$request->tahun;
        $this->save_log('tambah Tahun',$keterangan ,json_encode($query) );

        Alert::success('Success', 'Data berhasil di Simpan');
        return redirect('parameter/par_audit/tahun');
    }

    public function edit($id)
    {
        $getData = ParTahunModel::where('id_tahun', $id)->first();

        return view('parameter/par_audit/par_tahun.edit', compact('getData'));
    }

    public function update(Request $request, $id)
    {
        DB::connection()->enableQueryLog();
        $this->validate($request, [
            'tahun' => 'required|numeric'
        ]);
        $update = [
            'nama' => $request->tahun
        ];
        $ketTahun =  ParTahunModel::where('id_tahun', $id)->first();
        $keterangan = 'Update Tahun dengan ID '. $id. ', dari '.$ketTahun->nama. ' menjadi '.$request->tahun;

        $ParTahunModel = ParTahunModel::where('id_tahun', $id)->update($update);

        $cek = \Log::channel('database')->info($ParTahunModel);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('Update Tahun',$keterangan ,json_encode($query) );

        Alert::success('Success', 'Data berhasil di Update');
        return redirect('parameter/par_audit/tahun');
    }

    public function confrimDel($id)
    {
        $getData = ParTahunModel::where('id_tahun', $id)->first();
        return view('parameter/par_audit/par_tahun.delete', compact('getData'));
    }

    public function delete($id)
    {
        DB::connection()->enableQueryLog();
        $delete = [
            'status' => 0
        ];

        $ParTahunModel = ParTahunModel::where('id_tahun', $id)->update($delete);

        $cek = \Log::channel('database')->info($ParTahunModel);
        $query = DB::getQueryLog();
        $query = end($query);

        $keterangan = 'Delete Tahun dengan ID '. $id;
        $this->save_log('Delete Tahun ',$keterangan ,json_encode($query) );
        // $this->save_log('delete Tahun', $keterangan, $ParTahunModel );

        Alert::success('Success', 'Data berhasil di Delete');
        return redirect('parameter/par_audit/tahun');
    }

    // public function edittahun($id){
    //     $getTahun = ParTahunModel::where('id_tahun', $id)->first();
    //     return \response()->json($getTahun);
    //     // dd($getTahun);

    // }
}
