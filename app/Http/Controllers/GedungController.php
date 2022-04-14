<?php

namespace App\Http\Controllers;

use App\Models\GedungModels;
use Illuminate\Http\Request;
use App\Models\TransaksiModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class GedungController extends Controller
{
    public function index(Request $request)
    {
        return view('master_inventaris/gedung.index');
    }

    public function get_data_gedung(Request $request){
        $Datagedung = GedungModels::orderBy('data_gedung_id', 'asc')->get();

        return DataTables::of($Datagedung)
            ->addColumn('actions', 'master_inventaris/gedung.actions')
            ->rawColumns(['actions'])
            ->addIndexColumn()
            ->make(true);
    }

    public function save(Request $request){
        // dd($request->all());
        $request->validate([
            'kode_gedung' => 'required',
        ],
        [
            'kode_gedung.required' => 'Kode gedung tidak boleh kosong!'
        ]);

        $save = [
            'kode_data_gedung' => $request->kode_gedung,
            'nama_data_gedung' => $request->name_gedung,
        ];
        $saveDatagedung =GedungModels::create($save);
        if ($saveDatagedung) {
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
            'saveDatagedung'=> $saveDatagedung
        ]);

        $cek = \Log::channel('database')->info($saveDatagedung);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('tambah data gedung' ,json_encode($query));
    }

    public function edit(Request $request , $id){
        $getDatagedung = GedungModels::find($id);
        return response()->json($getDatagedung);
        // dd($getDataBagian);
    }

    public function update(Request $request){
        // dd($request->all());
        $save = [
            'kode_data_gedung' => $request->kode_gedung_e,
            'nama_data_gedung' => $request->name_gedung_e,
        ];

        $updatedata = GedungModels::where('data_gedung_id', $request->id_kd)->update($save);

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

        $cek = \Log::channel('database')->info($saveDatagedung);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('update data gedung' ,json_encode($query));
    }

    public function confrimDelete($id){

        $Datagedung = GedungModels::find($id);
        return view('master_inventaris/gedung.delete', compact('Datagedung'));
    }

    public function delete($id){

        $countGedung= TransaksiModels::where('trs_gedung_id', $id)->count();
        // dd($countGedung);
        if($countGedung){

            Alert::error('Upsss', 'Data sedang di pakai di modul transaksi');
            return redirect('m_inventaris/gedung');

        }else{

            $getDatagedung = GedungModels::where('data_gedung_id',$id)->delete();

            $cek = \Log::channel('database')->info($getDatagedung);
            $query = DB::getQueryLog();
            $query = end($query);
            $this->save_log('delete data gedung' ,json_encode($query));

            Alert::success('Success', 'Data berhasil di Hapus');
            return redirect('m_inventaris/gedung');
        }

    }
}
