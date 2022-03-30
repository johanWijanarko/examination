<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataKelompokModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class DataKelompokController extends Controller
{
    public function index(Request $request)
    {
        return view('master_inventaris/data_kelompok.index');
    }
    public function get_data_kelompok(Request $request){
        $dataKelompok = DataKelompokModels::orderBy('data_kelompok_id', 'asc')->get();

        return DataTables::of($dataKelompok)
            ->addColumn('actions', 'master_inventaris/data_kelompok.actions')
            ->rawColumns(['actions'])
            ->addIndexColumn()
            ->make(true);
    }

    public function save(Request $request){

        $request->validate([
            'kode_kelompok' => 'required',
        ],
        [
            'kode_kelompok.required' => 'Kode bagian tidak boleh kosong!'
        ]);

        $save = [
            'kode_data_kelompok' => $request->kode_kelompok,
            'nama_data_kelompok' => $request->nama_kelompok,
        ];
        $saveDataKelompok =DataKelompokModels::create($save);
        if ($saveDataKelompok) {
            $success = true;
            $message = "Data berhasil di Simpan";
        } else {
            $success = true;
            $message = "Data gagal di Simpan";
        }

        $cek = \Log::channel('database')->info($saveDataKelompok);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('tambah data kelompok' ,json_encode($query ));
        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
            'saveDataKelompok'=> $saveDataKelompok
        ]);
        
    }

    public function edit(Request $request , $id){
        $getdataKelompok = DataKelompokModels::find($id);
        return response()->json($getdataKelompok);
        // dd($getDataBagian);
    }

    public function update(Request $request){
        // dd($request->all());
        $save = [
            'kode_data_kelompok' => $request->kode_kelompok_e,
            'nama_data_kelompok' => $request->nama_kelompok_e,
        ];

        $updatedata = DataKelompokModels::where('data_kelompok_id', $request->id_kd)->update($save);

        if ($updatedata == 1) {
            $success = true;
            $message = "Data berhasil di Update";
        } else {
            $success = true;
            $message = "Data gagal di Update";
        }

        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
            'updatedata'=> $updatedata
        ]);

        $cek = \Log::channel('database')->info($updatedata);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('update data kelompok' ,json_encode($query ));
    }

    public function confrimDelete($id){

        $dataKelompok = DataKelompokModels::find($id);
        return view('master_inventaris/data_kelompok.delete', compact('dataKelompok'));
    }

    public function delete($id){
        
        $getDataKelompok = DataKelompokModels::where('data_kelompok_id',$id)->delete();

        $cek = \Log::channel('database')->info($getDataKelompok);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('delete data kelompok' ,json_encode($query ));

        Alert::success('Success', 'Data berhasil di Hapus');
        return redirect('m_inventaris/data_kelompok');
    }
}
