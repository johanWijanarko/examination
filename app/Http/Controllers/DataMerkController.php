<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataMerkModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class DataMerkController extends Controller
{
    public function index(Request $request)
    {
        return view('master_inventaris/data_merk.index');
    }

    public function get_data_Merk(Request $request){
        $Datamerk = DataMerkModels::orderBy('data_merk_id', 'asc')->get();

        return DataTables::of($Datamerk)
            ->addColumn('actions', 'master_inventaris/data_merk.actions')
            ->rawColumns(['actions'])
            ->addIndexColumn()
            ->make(true);
    }

    public function save(Request $request){

        $request->validate([
            'kode_Merk' => 'required',
        ],
        [
            'kode_Merk.required' => 'Kode Merk tidak boleh kosong!'
        ]);

        $save = [
            'kode_data_merk' => $request->kode_Merk,
            'nama_data_merk' => $request->nama_Merk,
        ];
        $saveDatamerk =DataMerkModels::create($save);
        if ($saveDatamerk) {
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
            'saveDatamerk'=> $saveDatamerk
        ]);

        $cek = \Log::channel('database')->info($saveDatamerk);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('save data merk' ,json_encode($query ));
    }

    public function edit(Request $request , $id){
        $getDatamerk = DataMerkModels::find($id);
        return response()->json($getDatamerk);
        // dd($getDataBagian);
    }

    public function update(Request $request){
        // dd($request->all());
        $save = [
            'kode_data_merk' => $request->kode_Merk_e,
            'nama_data_merk' => $request->nama_Merk_e,
        ];

        $updatedata = DataMerkModels::where('data_merk_id', $request->id_kd)->update($save);

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
        $this->save_log('update data merk' ,json_encode($query ));
    }

    public function confrimDelete($id){

        $Datamerk = DataMerkModels::find($id);
        return view('master_inventaris/data_merk.delete', compact('Datamerk'));
    }

    public function delete($id){
        
        $getDatamerk = DataMerkModels::where('data_merk_id',$id)->delete();

        $cek = \Log::channel('database')->info($getDatamerk);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('delete data merk' ,json_encode($query ));

        Alert::success('Success', 'Data berhasil di Hapus');
        return redirect('m_inventaris/data_merk');
    }
}
