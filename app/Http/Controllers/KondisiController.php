<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KondisiModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class KondisiController extends Controller
{
    public function index(Request $request)
    {
        return view('master_inventaris/kondisi.index');
    }

    public function get_data_Kondisi(Request $request){
        $DataKondisi = KondisiModels::orderBy('data_kondisi_id', 'asc')->get();

        return DataTables::of($DataKondisi)
            ->addColumn('actions', 'master_inventaris/kondisi.actions')
            ->rawColumns(['actions'])
            ->addIndexColumn()
            ->make(true);
    }

    public function save(Request $request){
        // dd($request->all());
        $request->validate([
            'kode_Kondisi' => 'required',
        ],
        [
            'kode_Kondisi.required' => 'Kode kondisi tidak boleh kosong!'
        ]);

        $save = [
            'kode_data_kondisi' => $request->kode_Kondisi,
            'nama_data_kondisi' => $request->nama_Kondisi,
        ];
        $saveDataKondisi =KondisiModels::create($save);
        if ($saveDataKondisi) {
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
            'saveDataKondisi'=> $saveDataKondisi
        ]);

        $cek = \Log::channel('database')->info($saveDataKondisi);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('tambah data kondisi' ,json_encode($query));
    }

    public function edit(Request $request , $id){
        $getDataKondisi = KondisiModels::find($id);
        return response()->json($getDataKondisi);
        // dd($getDataBagian);
    }

    public function update(Request $request){
        // dd($request->all());
        $save = [
            'kode_data_kondisi' => $request->kode_Kondisi_e,
            'nama_data_kondisi' => $request->nama_Kondisi_e,
        ];

        $updatedata = KondisiModels::where('data_kondisi_id', $request->id_kd)->update($save);

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
        $this->save_log('update data kondisi' ,json_encode($query));
    }

    public function confrimDelete($id){

        $DataKondisi = KondisiModels::find($id);
        return view('master_inventaris/kondisi.delete', compact('DataKondisi'));
    }

    public function delete($id){
        
        $getDataKondisi = KondisiModels::where('data_kondisi_id',$id)->delete();

        $cek = \Log::channel('database')->info($getDataKondisi);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('delete data kondisi' ,json_encode($query));

        Alert::success('Success', 'Data berhasil di Hapus');
        return redirect('m_inventaris/kondisi');
    }
}
