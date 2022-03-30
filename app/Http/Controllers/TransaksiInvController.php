<?php

namespace App\Http\Controllers;

use App\Models\GedungModels;
use Illuminate\Http\Request;
use App\Models\KondisiModels;
use App\Models\PegawaiModels;
use App\Models\RuanganModels;
use App\Models\DataMerkModels;
use App\Models\SupplierModels;
use Illuminate\Support\Carbon;
use App\Models\ParBagianModels;
use App\Models\SubBagianModels;
use App\Models\TypeKtegoryModels;
use App\Models\DataKelompokModels;
use App\Models\TransaksiDataModel;
use Illuminate\Support\Facades\DB;
use App\Models\DataManajemenModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class TransaksiInvController extends Controller
{
    public function index(){
       
        return \view('transaksi/inventaris.index');
    }

    public function getTrsInv()
    {
        $trsInv = TransaksiDataModel::with(['trsHasData','trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic'])
        ->orderBy('trs_id', 'desc')->where('trs_jenis_id',4)->get();

        return DataTables::of($trsInv)
            // ->addColumn('actions', 'transaksi/dataName.actions')
            ->addColumn('details_url', function(TransaksiDataModel $dp) {
               if ($dp->trsHasData) {
                   $btn = '<button data-url="'.route("detail_trsInv",['id'=>$dp->trsHasData->data_manajemen_id,'id_trs'=>$dp->trs_id ]).' " data-toggle="tooltip" data-placement="top" title="Detail" class="btn btn-success mr-1 btn-sm cek">Detail</button>';
                    $btn = $btn.'<a href="'.route("edit_trsInv",['id'=>$dp->trs_id]).'" class="edit btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit">Edit</a>';
                   return $btn;
                }
                return '';
            })
            ->addColumn('dataName', function (TransaksiDataModel $dp) {
                if ($dp->trsHasData) {
                    return $dp->trsHasData->data_manajemen_name;
                }
                return '';
            })
            ->addColumn('pegawai', function (TransaksiDataModel $dt) {
                if ($dt->trsHasPegawai) {
                    return $dt->trsHasPegawai->pegawai_name;
                }
                return '';
            })
            ->addColumn('sub', function (TransaksiDataModel $dk) {
                if ($dk->trsHasSubBagian) {
                    return $dk->trsHasSubBagian->sub_bagian_nama;
                }
                return '';
            })
             ->addColumn('bagian', function (TransaksiDataModel $dg) {
                if ($dg->trsHasBagian) {
                    return $dg->trsHasBagian->nama_bagian;
                }
                return '';
            })
            ->addColumn('status', function (TransaksiDataModel $dp) {
                $status = [ 
                    '1' => 'Dipakai',
                    '2' => 'Dipinjam',
                    '3' => 'Diperbaiki',
                    '4' => 'Dikembalikan',
                    '5' => 'Dimutasi',
                ];
                
                if ($dp->trs_status_id) {
                    return $status[$dp->trs_status_id];
                }
                return '';
            })
            ->rawColumns(['actions', 'dataName', 'pegawai', 'sub', 'bagian', 'details_url'])
            ->addIndexColumn()
            ->make(true);
    }

    public function detail($id, $id_trs)
    {
        $DatadataName = TransaksiDataModel::with(['trsHasData' => function($q) use ($id){
            $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi', 'manajemenHasSupplier']);
            $q->where('data_manajemen_id', $id);
        }, 'trsHasGedung', 'trsHasRuangan', 'trsHasKondisi'])
        ->where('trs_id', $id_trs)
        ->get();


        return DataTables::of($DatadataName)
            ->addColumn('merk', function (TransaksiDataModel $dp) {
                if ($dp->trsHasData->manajemenHasMerk) {
                    return $dp->trsHasData->manajemenHasMerk->nama_data_merk;
                }
                return '';
            })
            ->addColumn('type', function (TransaksiDataModel $dt) {
                if ($dt->trsHasData->manajemenHasType) {
                    return $dt->trsHasData->manajemenHasType->nama_data_type;
                }
                return '';
            })
            ->addColumn('kondisi', function (TransaksiDataModel $dk) {
                if ($dk->trsHasKondisi) {
                    return $dk->trsHasKondisi->nama_data_kondisi;
                }
                return '';
            })
            ->addColumn('gedung', function (TransaksiDataModel $dg) {
                if ($dg->trsHasGedung) {
                    return $dg->trsHasGedung->nama_data_gedung;
                }
                return '';
            })
            ->addColumn('ruangan', function (TransaksiDataModel $dr) {
                if ($dr->trsHasRuangan) {
                    return $dr->trsHasRuangan->nama_data_ruangan;
                }
                return '';
            })
            ->addColumn('supplier', function (TransaksiDataModel $ds) {
                if ($ds->trsHasData->manajemenHasSupplier) {
                    return $ds->trsHasData->manajemenHasSupplier->supplier_name;
                }
                return '';
            })
            ->addColumn('kelompok', function (TransaksiDataModel $ds) {
                if ($ds->trsHasKelompok) {
                    return $ds->trsHasKelompok->nama_data_kelompok;
                }
                return '';
            })
            ->rawColumns(['merk', 'type', 'kondisi', 'gedung', 'ruangan', 'supplier', 'kelompok'])
            ->addIndexColumn()
            ->make(true);
    }


    public function tambah(Request $request)
    {
        // $getKodeTrs = '';
        $dataInv = DataManajemenModels::where('data_manajemen_kode_id',4)->where('data_manajemen_jumlah', '>', 0)->get();
        $dataPegawai = PegawaiModels::get();
        $kelompok = DataKelompokModels::get();
        $gedung = GedungModels::get();
        $ruangan = RuanganModels::get();
        $countTrs = TransaksiDataModel::all()->count()+1;
        $getKodeTrs = 'TRS-INV-' . $countTrs .'';

        
        return \view('transaksi/inventaris.tambah', \compact('dataPegawai','gedung','ruangan' ,'dataInv', 'kelompok', 'getKodeTrs'));
    }

    public function gatInv(Request $request)
    {
        $getInv =DataManajemenModels::where('data_manajemen_id', $request->get('id'))->where('data_manajemen_kode_id',4)->first();

        $getMerk = DataMerkModels::select('nama_data_merk')->where('data_merk_id', $getInv->data_manajemen_merk_id)->first();
        $typeKategory = TypeKtegoryModels::select('nama_data_type')->where('data_type_id', $getInv->data_manajemen_type_id)->first();
        $kondisi = KondisiModels::select('nama_data_kondisi','data_kondisi_id')->where('data_kondisi_id', $getInv->data_manajemen_kondisi_id)->first();
        $gedung = GedungModels::select('nama_data_gedung')->where('data_gedung_id', $getInv->data_manajemen_gedung_id)->first();
        $ruangan = RuanganModels::select('nama_data_ruangan')->where('data_ruangan_id', $getInv->data_manajemen_ruangan_id)->first();
        $supplier = SupplierModels::select('supplier_name')->where('supplier_id', $getInv->data_manajemen_supplier_id)->first();
        // dd($kondisi);

         return response()->json([
            'getMerk' => $getMerk,
            'typeKategory' => $typeKategory,
            'kondisi' => $kondisi,
            'gedung' => $gedung,
            'ruangan' => $ruangan,
            'supplier' => $supplier, 
            'getInv' => $getInv
        ]);
            
    }

    public function save(Request $request)
    {
        $request->validate([

            'keterangan' => 'required',
            'inv' => 'required',
            'pegawai' => 'required',
            'bagian' => 'required',
            'subBagian' => 'required',
            'kelompok' => 'required',
            'gedung' => 'required',
            'ruangan' => 'required',
            
        ],
        [
            'keterangan.required' => 'Keterangan tidak boleh kosong!',
            'inv.required' => ' Inventaris tidak boleh kosong!',
            'pegawai.required' => 'Pegawai tidak boleh kosong!',
            'bagian.required' => 'Bagian tidak boleh kosong!',
            'subBagian.required' => 'Sub Bagian tidak boleh kosong!',
            'kelompok.required' => 'Kelompok tidak boleh kosong!',
            'gedung.required' => 'Gedung tidak boleh kosong!',
            'ruangan.required' => 'Ruangan tidak boleh kosong!',
        ]);
        
        $save = [
            'trs_jenis_id'=> 4,
            'trs_kode'=> $request->id_trs_prkt,
            'trs_data_id'=> $request->inv,
            'trs_name'=> $request->keterangan,
            'trs_pegawai_id'=> $request->pegawai,
            'trs_bagian_id'=> $request->bagian_,
            'trs_sub_bagian_id'=> $request->subBagian_,
            'trs_kelompok_id'=> $request->kelompok,
            'trs_ruangan_id'=> $request->ruangan,
            'trs_gedung_id'=> $request->gedung,
            'trs_pic_id'=> Auth::user()->id,
            'trs_date'=> Carbon::today(),
            'trs_kondisi_id'=> $request->kondisi_id,
            'trs_status_id' => 1,
        ];

        $product = DataManajemenModels::find($request->inv);
        $product->decrement('data_manajemen_jumlah', 1);

        $product = DataManajemenModels::find($request->inv);
        $product->increment('data_manajemen_jumlah_pemakai', 1);
        
        $saveInv =TransaksiDataModel::create($save);

        $cek = \Log::channel('database')->info($saveInv);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('tambah data transaksi Inventaris' ,json_encode($query));

        Alert::success('Success', 'Data berhasil di Simpan');
        return redirect('transaksi_data/invtentaris_trans');
    }

    public function edit($id)
    {
        $trsInv = TransaksiDataModel::with(['trsHasData'=> function ($q){
            $q->with(['manajemenHasMerk','manajemenHasType','manajemenHasKondisi','manajemenHasSupplier']);
        },'trsHasPegawai','trsHasSubBagian','trsHasBagian','trsHasPic'])
        ->orderBy('trs_id', 'asc')->where('trs_jenis_id',4)->where('trs_id', $id)->first();

        $dataInv = DataManajemenModels::where('data_manajemen_kode_id',4)->get();
        $dataPegawai = PegawaiModels::get();
        $kelompok = DataKelompokModels::get();
        $gedung = GedungModels::get();
        $ruangan = RuanganModels::get();
        
        //  dd($trsInv->trsHasData);
        return \view('transaksi/inventaris.edit', \compact('trsInv', 'dataPegawai', 'kelompok', 'dataInv', 'gedung', 'ruangan'));
    }

    public function update(Request $request , $id)
    {
        // dd($id);
        $request->validate([
           
            'keterangan' => 'required',
            'pegawai' => 'required',
            'bagian' => 'required',
            'subBagian' => 'required',
            'kelompok' => 'required',
            'gedung' => 'required',
            'ruangan' => 'required',
        ],
        [
            'keterangan.required' => 'Keterangan tidak boleh kosong!',
            'pegawai.required' => 'Pegawai tidak boleh kosong!',
            'bagian.required' => 'Bagian tidak boleh kosong!',
            'subBagian.required' => 'Sub Bagian tidak boleh kosong!',
            'kelompok.required' => 'Kelompok tidak boleh kosong!',
            'gedung.required' => 'Gedung tidak boleh kosong!',
            'ruangan.required' => 'Ruangan tidak boleh kosong!',
            
        ]);
        
        $save = [
            'trs_name'=> $request->keterangan,
            'trs_pegawai_id'=> $request->pegawai,
            'trs_bagian_id'=> $request->bagian_,
            'trs_sub_bagian_id'=> $request->subBagian_,
            'trs_kelompok_id'=> $request->kelompok,
            'trs_ruangan_id'=> $request->ruangan,
            'trs_gedung_id'=> $request->gedung,
            'trs_pic_id'=> Auth::user()->id,
            'trs_date'=> Carbon::today(),
        ];

        $updatedata = TransaksiDataModel::where('trs_id', $id)->update($save);

        $cek = \Log::channel('database')->info($updatedata);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('update data transaksi Inventaris' ,json_encode($query));

        Alert::success('Success', 'Data berhasil di Update');
        return redirect('transaksi_data/invtentaris_trans');
    }
}
