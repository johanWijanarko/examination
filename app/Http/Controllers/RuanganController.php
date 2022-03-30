<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RuanganModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class RuanganController extends Controller
{
    public function index(Request $request)
    {
        return view('master_inventaris/ruangan.index');
    }

    public function get_data_ruangan(Request $request){
        $DataRuangan = RuanganModels::orderBy('data_ruangan_id', 'asc')->get();

        return DataTables::of($DataRuangan)
            ->addColumn('actions', 'master_inventaris/ruangan.actions')
            ->rawColumns(['actions'])
            ->addIndexColumn()
            ->make(true);
    }

    public function save(Request $request){
        // dd($request->all());
        $request->validate([
            'kode' => 'required',
        ],
        [
            'kode.required' => 'Kode ruangan tidak boleh kosong!'
        ]);

        $save = [
            'kode_data_ruangan' => $request->kode,
            'nama_data_ruangan' => $request->ruangan,
        ];
        $saveDataRuangan =RuanganModels::create($save);
        if ($saveDataRuangan) {
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
            'saveDataRuangan'=> $saveDataRuangan
        ]);

        $cek = \Log::channel('database')->info($saveDataRuangan);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('tambah data ruang' ,json_encode($query));
    }

    public function edit(Request $request , $id){
        $getDataRuangan = RuanganModels::find($id);
        return response()->json($getDataRuangan);
        // dd($getDataBagian);
    }

    public function update(Request $request){
        // dd($request->all());
        $save = [
            'kode_data_ruangan' => $request->kode_e,
            'nama_data_ruangan' => $request->ruangan_e,
        ];

        $updatedata = RuanganModels::where('data_ruangan_id', $request->id_kd)->update($save);

        $cek = \Log::channel('database')->info($updatedata);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('update data ruang' ,json_encode($query));

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
    }

    public function confrimDelete($id){

        $DataRuangan = RuanganModels::find($id);
        return view('master_inventaris/ruangan.delete', compact('DataRuangan'));
    }

    public function delete($id){
        
        $getDataRuangan = RuanganModels::where('data_ruangan_id',$id)->delete();

        $cek = \Log::channel('database')->info($getDataRuangan);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('delete data ruang' ,json_encode($query));

        Alert::success('Success', 'Data berhasil di Hapus');
        return redirect('m_inventaris/ruangan');
    }
}
