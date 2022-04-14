<?php

namespace App\Http\Controllers;

use App\Models\StokModels;
use Illuminate\Http\Request;
use App\Models\TypeKtegoryModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class TipeKategoryController extends Controller
{
    public function index(Request $request)
    {
        return view('master_inventaris/type_kategory.index');
    }

    public function get_data_kategori(Request $request){
        $dataKategory = TypeKtegoryModels::orderBy('data_type_id', 'asc')->get();

        return DataTables::of($dataKategory)
            ->addColumn('actions', 'master_inventaris/type_kategory.actions')
            ->rawColumns(['actions'])
            ->addIndexColumn()
            ->make(true);
            // dd($dataKategory);
    }

    public function save(Request $request){
        // dd($request->all());
        $request->validate([
            'kode_kategory' => 'required',
        ],
        [
            'kode_kategory.required' => 'Kode Merk tidak boleh kosong!'
        ]);

        $save = [
            'kode_data_type' => $request->kode_kategory,
            'nama_data_type' => $request->nama_kategory,
        ];
        $saveDatamerk =TypeKtegoryModels::create($save);

        $cek = \Log::channel('database')->info($saveDatamerk);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('tambah data type' ,json_encode($query));

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
    }

    public function edit(Request $request , $id){
        $getdataKategory = TypeKtegoryModels::find($id);
        return response()->json($getdataKategory);
        // dd($getDataBagian);
    }

    public function update(Request $request){
        // dd($request->all());
        $save = [
            'kode_data_type' => $request->kode_kategory_e,
            'nama_data_type' => $request->nama_kategory_e,
        ];

        $updatedata = TypeKtegoryModels::where('data_type_id', $request->id_kd)->update($save);

        $cek = \Log::channel('database')->info($updatedata);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('update data type' ,json_encode($query));

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

        $Datamerk = TypeKtegoryModels::find($id);
        return view('master_inventaris/type_kategory.delete', compact('Datamerk'));
    }

    public function delete($id){
        $countMerk = StokModels::where('data_kategory_id', $id)->count();
        if($countMerk){

            Alert::error('Upsss', 'Data sedang di pakai di modul stok data');
            return redirect('m_inventaris/data_kategori');

        }else{

            $getDatamerk = TypeKtegoryModels::where('data_type_id',$id)->delete();

            $cek = \Log::channel('database')->info($getDatamerk);
            $query = DB::getQueryLog();
            $query = end($query);
            $this->save_log('delete data type' ,json_encode($query));

            Alert::success('Success', 'Data berhasil di Hapus');
            return redirect('m_inventaris/data_kategori');

        }

    }
}
