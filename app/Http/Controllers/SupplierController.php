<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use Illuminate\Http\Request;
use App\Models\ProvinsiModels;
use App\Models\SupplierModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $provinsis = DB::table('par_provinsi')->select('id', 'name')->orderBy('name', 'asc')->get();
        return view('master_inventaris/supplier.index' , compact('provinsis'));
    }
    

    public function get_data_supplier(Request $request){
        $DataSupplier = SupplierModels::with('supplierhasProvinsi','supplierhaskabupaten')
        ->orderBy('supplier_id', 'asc')->get();

        return DataTables::of($DataSupplier)
        ->addColumn('actions', 'master_inventaris/supplier.actions')
        ->addColumn('provinsi', function ($DataSupplier) {
                if ($DataSupplier->supplierhasProvinsi) {
                    return $DataSupplier->supplierhasProvinsi->name;
                }
                return '';
        })
        ->addColumn('kabupaten', function ($DataSupplier) {
                if ($DataSupplier->supplierhaskabupaten) {
                    return $DataSupplier->supplierhaskabupaten->name;
                }
                return '';
        })
        ->rawColumns(['actions', 'provinsi', 'kabupaten'])
        ->addIndexColumn()
        ->make(true);
        dd($DataSupplier);
    }

    public function save(Request $request){

        $request->validate([
            'kode_sup' => 'required',
            'prov' => 'required',
            'kabupaten' => 'required',
        ],
        [
            'kode_sup.required' => 'Kode tidak boleh kosong!',
            'prov.required' => 'Provinsi tidak boleh kosong!',
            'kabupaten.required' => 'Kabupaten tidak boleh kosong!'
        ]);

        $save = [
            'supplier_kode' => $request->kode_sup,
            'supplier_name' => $request->nama_sup,
            'supplier_alamat' => $request->alamat_sup,
            'supplier_provinsi_id' => $request->prov,
            'supplier_kabupaten_id' => $request->kabupaten,
        ];
        // dd($save);
        $saveDataSupplier =SupplierModels::create($save);

        $cek = \Log::channel('database')->info($saveDataSupplier);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('tambah data supplier' ,json_encode($query));

        if ($saveDataSupplier) {
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
            'saveDataSupplier'=> $saveDataSupplier
        ]);
    }

    public function edit(Request $request , $id){
        $getDataSupplier = SupplierModels::find($id);
        return response()->json($getDataSupplier);
        // dd($getDataSupplier);
    }
    
    public function get_kabupaten_sup(Request $request)
    {
        $get_kabupaten = DB::table('par_kabupaten')
            ->where('province_id', $request->get('id'))
            ->orderBy('name', 'asc')
            ->pluck('name', 'id');
        return response()->json($get_kabupaten);
    }
    public function get_prov_sup($id){
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

    public function get_kab_sup($id){
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
            'supplier_kode' => $request->kode_sup_e,
            'supplier_name' => $request->nama_sup_e,
            'supplier_alamat' => $request->alamat_sup_e,
            'supplier_provinsi_id' => $request->prov_e,
            'supplier_kabupaten_id' => $request->kabupaten_e,
        ];

        $updatedata = SupplierModels::where('supplier_id', $request->id_kd)->update($save);

        $cek = \Log::channel('database')->info($updatedata);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('update data supplier' ,json_encode($query));

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

        $DataSupplier = SupplierModels::find($id);
        return view('master_inventaris/supplier.delete', compact('DataSupplier'));
    }

    public function delete($id){
        
        $getDataSupplier = SupplierModels::where('supplier_id',$id)->delete();

        $cek = \Log::channel('database')->info($getDataSupplier);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('delete data supplier' ,json_encode($query));

        Alert::success('Success', 'Data berhasil di Hapus');
        return redirect('m_inventaris/supplier');
    }
}
