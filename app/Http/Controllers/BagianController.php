<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParBagianModels;
use App\Models\PegawaiModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class BagianController extends Controller
{
    public function index(Request $request)
    {
        return view('master_inventaris/bagian.index');
    }

    public function getDataBagian(Request $request){
        $bagian = ParBagianModels::orderBy('bagian_id', 'asc')->get();

        return DataTables::of($bagian)
            ->addColumn('actions', 'master_inventaris/bagian.actions')
            ->rawColumns(['actions'])
            ->addIndexColumn()
            ->make(true);
    }

    public function save(Request $request){
       $request->validate([
            'kode_bagian' => 'required',
        ],
        [
            'kode_bagian.required' => 'Kode bagian tidak boleh kosong!'
        ]);

        $save = [
            'kode_bagian' => $request->kode_bagian,
            'nama_bagian' => $request->bagian,
        ];
        $bagian = ParBagianModels::create($save);

        $cek = \Log::channel('database')->info($bagian);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('tambah bagian' ,json_encode($query ));

        Alert::success('Success', 'Data berhasil di Simpan');
        return redirect('m_inventaris/bagian');
    }

    public function edit(Request $request , $id){
        $getDataBagian = ParBagianModels::find($id);
        return response()->json($getDataBagian);
        // dd($getDataBagian);
    }

    public function update(Request $request){

        $save = [
            'kode_bagian' => $request->kode_b,
            'nama_bagian' => $request->nama_b,
        ];

        $updatedata = ParBagianModels::where('bagian_id', $request->id_kd)->update($save);

        $cek = \Log::channel('database')->info($updatedata);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('update bagian' ,json_encode($query ));

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

        $getDataBagian = ParBagianModels::find($id);
        return view('master_inventaris/bagian.delete', compact('getDataBagian'));
    }

    public function delete($id){
        $checkBagian = PegawaiModels::where('pegawai_bagian_id', $id)->count();
        // dd($checBagian);
        if($checkBagian){
            Alert::error('Upsss', 'Data sedang di pakai di modul Pegawai');
            return redirect('m_inventaris/bagian');
        }else{
            $getDataBagian = ParBagianModels::where('bagian_id',$id)->delete();

            $cek = \Log::channel('database')->info($getDataBagian);
            $query = DB::getQueryLog();
            $query = end($query);
            $this->save_log('delete bagian' ,json_encode($query ));

            Alert::success('Success', 'Data berhasil di Hapus');
            return redirect('m_inventaris/bagian');
        }

    }
}
