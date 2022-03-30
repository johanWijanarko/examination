<?php

namespace App\Http\Controllers;

use App\Models\fungsiModels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class FungsiController extends Controller
{
    public function index(Request $request)
    {
        return view('master_inventaris/fungsi.index');
    }

    public function get_data_fungsi(Request $request){
        $DataFungsi = fungsiModels::orderBy('data_fungsi_id', 'asc')->get();

        return DataTables::of($DataFungsi)
            ->addColumn('actions', 'master_inventaris/fungsi.actions')
            ->rawColumns(['actions'])
            ->addIndexColumn()
            ->make(true);
    }

    public function save(Request $request){

        $request->validate([
            'kode_fungsi' => 'required',
        ],
        [
            'kode_fungsi.required' => 'Kode Fungsi tidak boleh kosong!'
        ]);

        $save = [
            'kode_data_fungsi' => $request->kode_fungsi,
            'nama_data_fungsi' => $request->nama_fungsi,
        ];
        $saveDataFungsi =fungsiModels::create($save);
        if ($saveDataFungsi) {
            $success = true;
            $message = "Data berhasil di Simpan";
        } else {
            $success = true;
            $message = "Data gagal di Simpan";
        }

        //  Return response
        return response()->json([
            'success' => $success,
            'message' => $message,
            'saveDataFungsi'=> $saveDataFungsi
        ]);

        $cek = \Log::channel('database')->info($saveDataFungsi);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('tambah data fungsi' ,json_encode($query));
    }

    public function edit(Request $request , $id){
        $getDataFungsi = fungsiModels::find($id);
        return response()->json($getDataFungsi);
        // dd($getDataBagian);
    }

    public function update(Request $request){
        // dd($request->all());
        $save = [
            'kode_data_fungsi' => $request->kode_fungsi_e,
            'nama_data_fungsi' => $request->nama_fungsi_e,
        ];

        $updatedata = fungsiModels::where('data_fungsi_id', $request->id_kd)->update($save);

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
        $this->save_log('update data fungsi' ,json_encode($query));
    }

    public function confrimDelete($id){

        $DataFungsi = fungsiModels::find($id);
        return view('master_inventaris/fungsi.delete', compact('DataFungsi'));
    }

    public function delete($id){
        
        $getDataFungsi = fungsiModels::where('data_fungsi_id',$id)->delete();

        $cek = \Log::channel('database')->info($getDataFungsi);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('delete data fungsi' ,json_encode($query));

        Alert::success('Success', 'Data berhasil di Hapus');
        return redirect('m_inventaris/data_fungsi');
    }
}
