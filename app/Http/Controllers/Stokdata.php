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

    public function getDataStok(Request $request)
    {

        $DataPerangkat = StokModels::with(['stokHasMerk','stokHasType','stokHasKondisi','stokHasSupplier'])
        ->orderBy('data_stok_id', 'asc')->where('data_status_id',1)->get();

        return DataTables::of($DataPerangkat)
            ->addColumn('details_url', function(StokModels $dp) {
                if ($dp->data_stok_id) {
                    $btn ='<a href="'.route("edit_stok",['id'=>$dp->data_stok_id]).'" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-sm btn-success rounded-circle " ><i class="fas fa-edit"></i></i></a>';
                    $btn =$btn.'<a data-toggle="modal" id="smallButton"  data-target="#smallModal" data-attr="'.route("confrimdelstok",['id'=>$dp->data_stok_id]).'" data-placement="top" title="delete" class="btn btn-sm btn-danger rounded-circle " ><i class="fas fa-trash"></i></a>';

                    return $btn;
                }
                return '';
            })
            ->addColumn('merk', function (StokModels $dp) {
                if ($dp->stokHasMerk) {
                    return $dp->stokHasMerk->nama_data_merk;
                }
                return '';
            })
            ->addColumn('type', function (StokModels $dt) {
                if ($dt->stokHasType) {
                    return $dt->stokHasType->nama_data_type;
                }
                return '';
            })
            ->addColumn('kondisi', function (StokModels $dk) {
                if ($dk->stokHasKondisi) {
                    return $dk->stokHasKondisi->nama_data_kondisi;
                }
                return '';
            })
            ->addColumn('supplier', function (StokModels $ds) {
                if ($ds->stokHasSupplier) {
                    return $ds->stokHasSupplier->supplier_name;
                }
                return '';
            })

            ->rawColumns([ 'merk', 'type', 'kondisi', 'gedung', 'ruangan', 'supplier', 'details_url'])
            ->addIndexColumn()
            ->make(true);
    }

    public function tambah(Request $request)
    {
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

    public function edit($id){
        $getData = StokModels::find($id);

        $parMerks = DataMerkModels::orderBy('data_merk_id', 'ASC')->get();
        $parType = TypeKtegoryModels::orderBy('data_type_id', 'ASC')->get();
        $parKondisi = KondisiModels::orderBy('data_kondisi_id', 'ASC')->get();

        $parSuppliers = SupplierModels::orderBy('supplier_id', 'ASC')->get();

        return \view('manajemen_data/stok.edit',compact('getData', 'parMerks', 'parType', 'parKondisi', 'parSuppliers'));
        // dd($getData);
    }

    public function update(Request $request, $id){
        // dd($request->all());
        $request->validate([
            'data_name' => 'required',
            'type' => 'required',
            'kondisi' => 'required',
            'jumlah' => 'required',
            'supplier' => 'required',

        ],
        [
            'data_name.required' => 'Nama Perangkat tidak boleh kosong!',
            'type.required' => 'Type / Kategori tidak boleh kosong!',
            'kondisi.required' => 'Kondisi tidak boleh kosong!',
            'jumlah.required' => 'Jumlah tidak boleh kosong!',
            'supplier.required' => 'Supplier tidak boleh kosong!',
        ]);
        if ($request->up_jumlah > 0 ) {
            $tambah = StokModels::where('data_stok_id', $id)->first();
            $tambah->increment('data_jumlah', $request->up_jumlah);
            $save = [
                'data_kategory_id' => $request->type,
                'data_merk_id' => $request->merk,
                'data_name' => $request->data_name,
                'data_kondisi_id' => $request->kondisi,
                'data_keterangan' => $request->keterangan,
                'data_supplier_id' => $request->supplier,
            ];
            // dd($save);
            $updatedata = StokModels::where('data_stok_id', $id)->update($save);

            $cek = Log::channel('database')->info($updatedata);
            $query = DB::getQueryLog();
            $query = end($query);
            $this->save_log('update data stok' ,json_encode($query));

        }else{
            $save = [
                'data_jumlah' => $request->jumlah,
                'data_kategory_id' => $request->type,
                'data_merk_id' => $request->merk,
                'data_name' => $request->data_name,
                'data_kondisi_id' => $request->kondisi,
                'data_keterangan' => $request->keterangan,
                'data_supplier_id' => $request->supplier,
            ];
            // dd($save);
            $updatedata = StokModels::where('data_stok_id', $id)->update($save);

            $cek = Log::channel('database')->info($updatedata);
            $query = DB::getQueryLog();
            $query = end($query);
            $this->save_log('update data perangkat' ,json_encode($query));
        }


        Alert::success('Success', 'Data berhasil di Update');
        return redirect('m_data/data_stok');
    }

    public function confrimDelete($id){
        $getData = StokModels::find($id);
        return \view('manajemen_data/stok.delete',compact('getData'));
    }

    public function delete($id){
        $delete = [
            'data_status_id' => 0
        ];
        $getData = StokModels::where('data_stok_id',$id)->update($delete);

            $cek = Log::channel('database')->info($getData);
            $query = DB::getQueryLog();
            $query = end($query);
            $this->save_log('delete data perangkat' ,json_encode($query));

        Alert::success('Success', 'Data berhasil di Hapus');
        return redirect('m_data/data_stok');
    }
}
