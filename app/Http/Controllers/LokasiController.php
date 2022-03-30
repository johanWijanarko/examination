<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use App\Models\LokasiModels;
use Illuminate\Http\Request;
use App\Models\ProvinsiModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class LokasiController extends Controller
{
    public function index(Request $request)
    {
        $provinsis = DB::table('par_provinsi')->select('id', 'name')->orderBy('name', 'asc')->get();
        return view('master_inventaris/lokasi.index', compact('provinsis'));
    }
    public function get_kabupaten(Request $request)
    {
        $get_kabupaten = DB::table('par_kabupaten')
            ->where('province_id', $request->get('id'))
            ->orderBy('name', 'asc')
            ->pluck('name', 'id');
        return response()->json($get_kabupaten);
    }

    public function get_data_lokasi(Request $request){
        $DataLokasi = LokasiModels::with('lokasihaskabupaten','lokasihasProvinsi')
        ->orderBy('lokasi_id', 'asc')->get();

        return DataTables::of($DataLokasi)
        ->addColumn('actions', 'master_inventaris/lokasi.actions')
        ->addColumn('provinsi', function ($DataLokasi) {
                if ($DataLokasi->lokasihasProvinsi) {
                    return $DataLokasi->lokasihasProvinsi->name;
                }
                return '';
        })
        ->addColumn('kabupaten', function ($DataLokasi) {
                if ($DataLokasi->lokasihaskabupaten) {
                    return $DataLokasi->lokasihaskabupaten->name;
                }
                return '';
        })
        ->rawColumns(['actions', 'provinsi', 'kabupaten'])
        ->addIndexColumn()
        ->make(true);
        dd($DataLokasi);
    }

    public function save(Request $request){

        $request->validate([
            'alamat' => 'required',
            'provinsi' => 'required',
        ],
        [
            'alamat.required' => 'Alamat tidak boleh kosong!',
            'provinsi.required' => 'Provinsi tidak boleh kosong!'
        ]);

        $save = [
            'lokasi_name' => $request->alamat,
            'lokasi_provinsi_id' => $request->provinsi,
            'lokasi_pkabupaten_id' => $request->kabupaten,
        ];
        // dd($save);
        $saveDataLokasi =LokasiModels::create($save);
        if ($saveDataLokasi) {
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
            'saveDataLokasi'=> $saveDataLokasi
        ]);

        $cek = \Log::channel('database')->info($saveDataLokasi);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('tambah data lokasi' ,json_encode($query));
    }

    public function edit(Request $request , $id){
        $getDataLokasi = LokasiModels::find($id);
        return response()->json($getDataLokasi);
        // dd($getDataLokasi);
    }

    public function get_prov_edit($id){
        $prov = ProvinsiModels::get();
        $output = '';
        // $output .= '';
        foreach ($prov as $provinsi){
            $id_prov = $provinsi->id;
            $name = $provinsi->name;

            $output .= '<option value="'.$id_prov.'" '.(($id_prov == $id) ? 'selected="selected"':"").'>'.$name.'</option>';
        }
        $output .='</select>';

        return $output;
    }

    public function get_kab_edit($id){
        $kab = Kabupaten::get();
        $output = '';
        // $output .= '';
        foreach ($kab as $kabupaten){
            $id_kab = $kabupaten->id;
            $name = $kabupaten->name;

            $output .= '<option value="'.$id_kab.'" '.(($id_kab == $id) ? 'selected="selected"':"").'>'.$name.'</option>';
        }
        $output .='</select>';

        return $output;
    }
    
    public function update(Request $request){
        // dd($request->all());
        $save = [
            'lokasi_name' => $request->alamat_e,
            'lokasi_provinsi_id' => $request->provinsi_e,
            'lokasi_pkabupaten_id' => $request->kabupaten_e,
        ];

        $updatedata = LokasiModels::where('lokasi_id', $request->id_kd)->update($save);

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
        $this->save_log('update data lokasi' ,json_encode($query));
    }

    public function confrimDelete($id){

        $DataLokasi = LokasiModels::find($id);
        return view('master_inventaris/lokasi.delete', compact('DataLokasi'));
    }

    public function delete($id){
        
        $getDataLokasi = LokasiModels::where('lokasi_id',$id)->delete();

        $cek = \Log::channel('database')->info($getDataLokasi);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('delete data lokasi' ,json_encode($query));

        Alert::success('Success', 'Data berhasil di Hapus');
        return redirect('m_inventaris/lokasi');
    }
}
