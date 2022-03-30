<?php

namespace App\Http\Controllers;

use App\Models\GedungModels;
use Illuminate\Http\Request;
use App\Models\KondisiModels;
use App\Models\RuanganModels;
use App\Models\DataMerkModels;
use App\Models\SupplierModels;
use App\Models\TypeKtegoryModels;
use Illuminate\Support\Facades\DB;
use App\Models\DataManajemenModels;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class DataPerangkatController extends Controller
{
    public function index(){
        return \view('manajemen_data/data_perangkat.index');
    }

    public function getDataPerangkat(Request $request){
        $DataPerangkat = DataManajemenModels::with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi','manajemenHasSupplier'])
        ->orderBy('data_manajemen_id', 'asc')->where('data_manajemen_kode_id',1)->get();

        return DataTables::of($DataPerangkat)
            ->addColumn('actions', 'manajemen_data/data_perangkat.actions')
            ->addColumn('merk', function (DataManajemenModels $dp) {
                if ($dp->manajemenHasMerk) {
                    return $dp->manajemenHasMerk->nama_data_merk;
                }
                return '';
            })
            ->addColumn('type', function (DataManajemenModels $dt) {
                if ($dt->manajemenHasType) {
                    return $dt->manajemenHasType->nama_data_type;
                }
                return '';
            })
            ->addColumn('kondisi', function (DataManajemenModels $dk) {
                if ($dk->manajemenHasKondisi) {
                    return $dk->manajemenHasKondisi->nama_data_kondisi;
                }
                return '';
            })
            ->addColumn('supplier', function (DataManajemenModels $ds) {
                if ($ds->manajemenHasSupplier) {
                    return $ds->manajemenHasSupplier->supplier_name;
                }
                return '';
            })
            ->addColumn('mutasi', function (DataManajemenModels $ds) {
                if ($ds->data_manajemen_jumlah_mutasi) {
                    return $ds->data_manajemen_jumlah_mutasi;
                }
                return 0 ;
            })
            ->addColumn('pinjam', function (DataManajemenModels $ds) {
                if ($ds->data_manajemen_jumlah_pinjam) {
                    return $ds->data_manajemen_jumlah_pinjam;
                }
                return 0 ;
            })
            ->rawColumns(['actions', 'merk', 'type', 'kondisi', 'gedung', 'ruangan', 'supplier'])
            ->addIndexColumn()
            ->make(true);
    }

    public function tambah(Request $request){
        $parMerks = DataMerkModels::orderBy('data_merk_id', 'ASC')->get();
        $parType = TypeKtegoryModels::orderBy('data_type_id', 'ASC')->get();
        $parKondisi = KondisiModels::orderBy('data_kondisi_id', 'ASC')->get();
        $parSuppliers = SupplierModels::orderBy('supplier_id', 'ASC')->get();

        return \view('manajemen_data/data_perangkat.tambah',compact('parMerks', 'parType', 'parKondisi', 'parSuppliers'));
    }

    public function save(Request $request){
        // dd($request->all());
        $request->validate([
            'nama_perangkat' => 'required',
            'merk' => 'required',
            'type' => 'required',
            'kondisi' => 'required',
            'jumlah' => 'required',
            'supplier' => 'required',
            
        ],
        [
            'nama_perangkat.required' => 'Nama Perangkat tidak boleh kosong!',
            'merk.required' => 'Merk tidak boleh kosong!',
            'type.required' => 'Type / Kategori tidak boleh kosong!',
            'kondisi.required' => 'Kondisi tidak boleh kosong!',
            'jumlah.required' => 'Jumlah tidak boleh kosong!',
            'supplier.required' => 'Supplier tidak boleh kosong!',
        ]);
        
        $save = [
            'data_manajemen_kode_id'=> 1,
            'data_manajemen_name' => $request->nama_perangkat,
            'data_manajemen_merk_id' => $request->merk,
            'data_manajemen_type_id' => $request->type,
            'data_manajemen_kondisi_id' => $request->kondisi,
            'data_manajemen_jumlah_awal' => $request->jumlah,
            'data_manajemen_jumlah' => $request->jumlah,
            'data_manajemen_keterangan' => $request->keterangan,
            'data_manajemen_supplier_id' => $request->supplier,
        ];
        $DataManajemen =DataManajemenModels::create($save);

        $cek = \Log::channel('database')->info($DataManajemen);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('tambah data perangkat' ,json_encode($query ));

        
        Alert::success('Success', 'Data berhasil di Simpan');
        return redirect('m_data/perangkat');
    }
    public function edit($id){
        $getData = DataManajemenModels::find($id);

        $parMerks = DataMerkModels::orderBy('data_merk_id', 'ASC')->get();
        $parType = TypeKtegoryModels::orderBy('data_type_id', 'ASC')->get();
        $parKondisi = KondisiModels::orderBy('data_kondisi_id', 'ASC')->get();
       
        $parSuppliers = SupplierModels::orderBy('supplier_id', 'ASC')->get();

        return \view('manajemen_data/data_perangkat.edit',compact('getData', 'parMerks', 'parType', 'parKondisi', 'parSuppliers'));
        // dd($getData);
    }

    public function update(Request $request, $id){
        // dd($request->all());
        $request->validate([
            'nama_perangkat' => 'required',
            'merk' => 'required',
            'type' => 'required',
            'kondisi' => 'required',
            'jumlah' => 'required',
            'supplier' => 'required',
            
        ],
        [
            'nama_perangkat.required' => 'Nama Perangkat tidak boleh kosong!',
            'merk.required' => 'Merk tidak boleh kosong!',
            'type.required' => 'Type / Kategori tidak boleh kosong!',
            'kondisi.required' => 'Kondisi tidak boleh kosong!',
            'jumlah.required' => 'Jumlah tidak boleh kosong!',
            'supplier.required' => 'Supplier tidak boleh kosong!',
        ]);
        if ($request->up_jumlah > 0 ) {
            $tambah = DataManajemenModels::where('data_manajemen_id', $id)->first();
            $tambah->increment('data_manajemen_jumlah', $request->up_jumlah);
            $save = [
                'data_manajemen_kode_id'=> 1,
                'data_manajemen_name' => $request->nama_perangkat,
                'data_manajemen_merk_id' => $request->merk,
                'data_manajemen_type_id' => $request->type,
                'data_manajemen_kondisi_id' => $request->kondisi,
                'data_manajemen_keterangan' => $request->keterangan,
                'data_manajemen_supplier_id' => $request->supplier,
            ];
            // dd($save);
            $updatedata = DataManajemenModels::where('data_manajemen_id', $id)->update($save);

            $cek = \Log::channel('database')->info($updatedata);
            $query = DB::getQueryLog();
            $query = end($query);
            $this->save_log('update data perangkat' ,json_encode($query));

        }else{
            $save = [
                'data_manajemen_kode_id'=> 1,
                'data_manajemen_name' => $request->nama_perangkat,
                'data_manajemen_merk_id' => $request->merk,
                'data_manajemen_type_id' => $request->type,
                'data_manajemen_kondisi_id' => $request->kondisi,
                'data_manajemen_jumlah' => $request->jumlah,
                'data_manajemen_keterangan' => $request->keterangan,
                'data_manajemen_supplier_id' => $request->supplier,
            ];
            // dd($save);
            $updatedata = DataManajemenModels::where('data_manajemen_id', $id)->update($save);

            $cek = \Log::channel('database')->info($updatedata);
            $query = DB::getQueryLog();
            $query = end($query);
            $this->save_log('update data perangkat' ,json_encode($query));
        }
        

        Alert::success('Success', 'Data berhasil di Update');
        return redirect('m_data/perangkat');
    }

    public function confrimDelete($id){
        $getData = DataManajemenModels::find($id);
        return \view('manajemen_data/data_perangkat.delete',compact('getData'));
    }

    public function delete($id){
        $getData = DataManajemenModels::where('data_manajemen_id',$id)->delete();

            $cek = \Log::channel('database')->info($getData);
            $query = DB::getQueryLog();
            $query = end($query);
            $this->save_log('delete data perangkat' ,json_encode($query));

        Alert::success('Success', 'Data berhasil di Hapus');
        return redirect('m_data/perangkat');
    }
}
