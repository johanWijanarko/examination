<?php

namespace App\Http\Controllers;

use App\Models\StokModels;
use Illuminate\Http\Request;
use App\Models\KondisiModels;
use App\Models\DataMerkModels;
use App\Models\SupplierModels;
use App\Models\TypeKtegoryModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class Stokdata extends Controller
{
    public function index(Request $request)
    {
        return \view('manajemen_data/stok.index');
    }

    public function getDataPerangkat(Request $request){
    
    $DataPerangkat = StokModels::with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi','manajemenHasSupplier'])
    ->orderBy('data_manajemen_id', 'asc')->where('data_manajemen_kode_id',1)->get();

    return DataTables::of($DataPerangkat)
        ->addColumn('actions', 'manajemen_data/data_perangkat.actions')
        ->addColumn('merk', function (StokModels $dp) {
            if ($dp->manajemenHasMerk) {
                return $dp->manajemenHasMerk->nama_data_merk;
            }
            return '';
        })
        ->addColumn('type', function (StokModels $dt) {
            if ($dt->manajemenHasType) {
                return $dt->manajemenHasType->nama_data_type;
            }
            return '';
        })
        ->addColumn('kondisi', function (StokModels $dk) {
            if ($dk->manajemenHasKondisi) {
                return $dk->manajemenHasKondisi->nama_data_kondisi;
            }
            return '';
        })
        ->addColumn('supplier', function (StokModels $ds) {
            if ($ds->manajemenHasSupplier) {
                return $ds->manajemenHasSupplier->supplier_name;
            }
            return '';
        })
        ->addColumn('mutasi', function (StokModels $ds) {
            if ($ds->data_manajemen_jumlah_mutasi) {
                return $ds->data_manajemen_jumlah_mutasi;
            }
            return 0 ;
        })
        ->addColumn('pinjam', function (StokModels $ds) {
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

        return \view('manajemen_data/stok.tambah',compact('parMerks', 'parType', 'parKondisi', 'parSuppliers'));
    }

    public function save(Request $request){
        // dd($request->all());
        $request->validate([
            'data_name' => 'required',
            // 'merk' => 'required',
            'type' => 'required',
            'kondisi' => 'required',
            'jumlah' => 'required',
            'supplier' => 'required',
            
        ],
        [
            'data_name.required' => 'Nama Perangkat tidak boleh kosong!',
            // 'merk.required' => 'Merk tidak boleh kosong!',
            'type.required' => 'Type / Kategori tidak boleh kosong!',
            'kondisi.required' => 'Kondisi tidak boleh kosong!',
            'jumlah.required' => 'Jumlah tidak boleh kosong!',
            'supplier.required' => 'Supplier tidak boleh kosong!',
        ]);
        
        $save = [
            'data_name' => $request->data_name,
            'data_merk_id' => $request->merk,
            'data_kategory_id' => $request->type,
            'data_kondisi_id' => $request->kondisi,
            'data_supplier_id' => $request->supplier,
            'data_jumlah' => $request->jumlah,
            'data_keterangan' => $request->keterangan,
        ];
        $DataManajemen =StokModels::create($save);

        $cek = Log::channel('database')->info($DataManajemen);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('tambah data perangkat' ,json_encode($query ));

        
        Alert::success('Success', 'Data berhasil di Simpan');
        return redirect('m_data/data_stok');
    }
}
