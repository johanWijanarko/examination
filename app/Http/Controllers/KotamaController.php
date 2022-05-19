<?php

namespace App\Http\Controllers;

use App\Models\Kotama;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class KotamaController extends Controller
{
    public function index(Request $request){
        return view('master/kotama.index');
    }

    public function getDataKotama(Request $request){
        $getDataKotama = Kotama::orderBy('id', 'asc')->where('del_st_kotama', 1)->get();

        return DataTables::of($getDataKotama)
            ->addColumn('actions', 'master/kotama.actions')
            ->rawColumns(['actions'])
            ->addIndexColumn()
            ->make(true);

    }

    public function save(Request $request){
        // dd($request->all());
        $request->validate([
            'kode_kotama' => 'required',
            'nama_kotama' => 'required',
        ],
        [
            'kode_kotama.required' => 'Kode kotama tidak boleh kosong!',
            'nama_kotama.required' => 'Nama kotama tidak boleh kosong!'
        ]);

        $save = [
            'kode_kotama' => $request->kode_kotama,
            'nama_kotama' => $request->nama_kotama,
        ];


        $saveKotama =Kotama::create($save);

        if ($saveKotama) {
            $success = true;
            $message = "Data berhasil di Simpan";
        } else {
            $success = true;
            $message = "Data gagal di Simpan";
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'saveKotama'=> $saveKotama
        ]);
    }

    public function edit(Request $request, $id){
        $getDataKotama = Kotama::find($id);
        return response()->json($getDataKotama);
    }

    public function update(Request $request){
        $request->validate([
            'kode_e' => 'required',
            'name_e' => 'required',
        ],
        [
            'kode_e.required' => 'Kode kotama tidak boleh kosong!',
            'name_e.required' => 'Nama kotama tidak boleh kosong!'
        ]);
        
        $save = [
            'kode_kotama' => $request->kode_e,
            'nama_kotama' => $request->name_e,
        ];
        // dd($save);
        
        $updatedata = Kotama::where('id', $request->id_kd)->update($save);

        if ($updatedata) {
            $success = true;
            $message = "Data berhasil di Simpan";
        } else {
            $success = true;
            $message = "Data gagal di Simpan";
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'updatedata'=> $updatedata
        ]);
    }

    public function confrimDelete($id){

        $dataKotama = Kotama::find($id);
        
        return view('master/kotama.delete', compact('dataKotama'));
    }

    public function delete($id){
        $updatedata = Kotama::where('id', $id)->update(['del_st_kotama'=> 0]);
        Alert::success('Success', 'Data berhasil di Hapus');
        return redirect('master/kotama');

    }

}
