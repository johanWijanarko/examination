<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParBagianModels;
use App\Models\SubBagianModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class SubBagianController extends Controller
{
    public function index(Request $request)
    {
        $bagians = ParBagianModels::get();
        return view('master_inventaris/sub_bagian.index',\compact('bagians'));
    }

    public function getDataSubBagian(Request $request){
        $subBagian = SubBagianModels::with('getBagian')->orderBy('sub_bagian_id', 'asc')->get();

        return DataTables::of($subBagian)
            ->addColumn('actions', 'master_inventaris/sub_bagian.actions')
            ->addColumn('bagian', function ($subBagian) {
                if ($subBagian->getBagian) {
                    return $subBagian->getBagian->nama_bagian;
                }
                return '';
            })
            ->rawColumns(['actions', 'bagian'])
            ->addIndexColumn()
            ->make(true);
    }

    public function save(Request $request){
        $request->validate([
            'bagian' => 'required',
        ],
        [
            'bagian.required' => 'Kode bagian tidak boleh kosong!'
        ]);

        $save = [
            'sub_bagian_bagian_id' => $request->bagian,
            'sub_bagian_kode' => $request->kodeSubBagian,
            'sub_bagian_nama' => $request->namaSubBagian,
        ];

        $subbagian = SubBagianModels::create($save);

        $cek = \Log::channel('database')->info($subbagian);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('tambah data subbagian' ,json_encode($query));

        Alert::success('Success', 'Data berhasil di Simpan');
        return redirect('m_inventaris/sub_bagian');
    }

    public function edit(Request $request , $id){
        $getDataSuBagian = SubBagianModels::find($id);

        return response()->json($getDataSuBagian);
    }

    public function getBagianselected($id){
        $bagians = ParBagianModels::orderBy('bagian_id','ASC')->get();
        $output = '';
        // $output .= '';
        foreach ($bagians as $bagian){
            $bagian_id = $bagian->bagian_id;
            $nama_bagian = $bagian->nama_bagian;

            $output .= '<option value="'.$bagian_id.'" '.(($bagian_id == $id) ? 'selected="selected"':"").'>'.$nama_bagian.'</option>';
        }
        $output .='</select>';

        return $output;
    }
    public function update(Request $request){

        $request->validate([
            'kdBagian_e' => 'required',
        ],
        [
            'kdBagian_e.required' => 'Kode bagian tidak boleh kosong!'
        ]);

        $save = [
            'sub_bagian_bagian_id' => $request->kdBagian_e,
            'sub_bagian_kode' => $request->kodesubbagian_e,
            'sub_bagian_nama' => $request->namaSubbagian_e,
        ];

        $updatedata = SubBagianModels::where('sub_bagian_id', $request->id_kd)->update($save);

        $cek = \Log::channel('database')->info($updatedata);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('update data subbagian' ,json_encode($query));

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

    public function confrimdelsubbag($id){

        $getDataSubBagian = SubBagianModels::find($id);
        return view('master_inventaris/sub_bagian.delete', compact('getDataSubBagian'));
    }

    public function delete($id){
        
        $getDataBagian = SubBagianModels::where('sub_bagian_id',$id)->delete();

        $cek = \Log::channel('database')->info($getDataBagian);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('delete data subbagian' ,json_encode($query));

        Alert::success('Success', 'Data berhasil di Hapus');
        return redirect('m_inventaris/sub_bagian');
    }
}
