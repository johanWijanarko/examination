<?php

namespace App\Http\Controllers;

use App\Models\StokModels;
use App\Models\GedungModels;
use Illuminate\Http\Request;
use App\Models\KondisiModels;
use App\Models\PegawaiModels;
use App\Models\RuanganModels;
use App\Models\DataMerkModels;
use App\Models\SupplierModels;
use Illuminate\Support\Carbon;
use App\Models\DetailTransaksi;
use App\Models\ParBagianModels;
use App\Models\SubBagianModels;
use App\Models\TransaksiModels;
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
        $trsInv = TransaksiModels::with(['trsDetail' =>function ($q){
            $q->with(['trsHasPegawai2' ]);
            $q->whereHas('trsHasStok2', function($q){
                $q->where('data_kategory_id',5);
            });
        }])->whereHas('trsDetail', function ($q){
            $q->whereHas('trsHasStok2', function($q){
                $q->where('data_kategory_id',5);
            });
        })
        ->orderBy('trs_id', 'asc')->where('trs_status_id',1)
        ->get();

       
        return DataTables::of($trsInv)
            ->addColumn('details_url', function(TransaksiModels $dp) {
               if ($dp->trs_id) {
                $btn ='<a href="'.route("edit_trsInv",['id'=>$dp->trs_id]).'" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-sm btn-warning rounded-circle " ><i class="fas fa-edit"></i></i></a>';
                $btn =$btn.'<a data-toggle="modal" id="smallButton"  data-target="#smallModal" data-attr="'.route("detail_trsInv",['id'=>$dp->trs_id]).'" data-placement="top" title="Edit" class="btn btn-sm btn-success rounded-circle " ><i class="fas fa-eye"></i></a>';
                return $btn;
                }
                return '';
            })
            ->addColumn('perangkat', function (TransaksiModels $dp) {
                if ($dp->trsDetail) {
                    foreach ($dp->trsDetail as $key => $detail) {
                        if($detail->trsHasStok2){
                            return $detail->trsHasStok2->data_name;
                        }
                       
                    }
                }
                return '';
            })
            ->addColumn('pegawai', function (TransaksiModels $dp) {
                $detail_='';
                if ($dp->trsDetail) {
                    foreach ($dp->trsDetail as $key_1 => $detail) {
                        
                        if($detail->hasManyPegawai){
                            $angka = $key_1+1;
                            foreach ($detail->hasManyPegawai as $key => $value) {
                                $detail_ .= $angka.'. '.$value->pegawai_name.'<br>';
                            }
                        }
                       
                    }
                }
                return $detail_;
            })
            ->addColumn('status', function (TransaksiModels $dp) {
                $status = [
                    '1' => 'Dipakai',
                    '2' => 'Dipinjam',
                    '3' => 'Sedang diperbaiki',
                    '4' => 'Dikembalikan',
                    '5' => 'Dimutasi',
                ];

                $detail_2='';
                if ($dp->trsDetail) {
                    foreach ($dp->trsDetail as $key_1 => $detail) {
                        $angka = $key_1+1;
                        $detail_2 .=  $angka.'. '.$status[$detail->trs_detail_status].'<br>';
                    }
                    
                }
               
                return $detail_2;
            })
            ->addColumn('keterangan', function (TransaksiModels $dp) {
                if ($dp) {
                    return $dp->trs_keterangan;
                }
                return '';
            })
            ->rawColumns(['actions', 'perangkat', 'pegawai', 'details_url', 'status'])
            ->addIndexColumn()
            ->make(true);
    }

    public function detail($id)
    {
        $details = TransaksiModels::with(['trsDetail'=> function($q){
            $q->with(['trsHasPegawai2' => function($q){
                $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
            }, 'trsHasStok2'=> function ($q){
                $q->with(['stokHasMerk','stokHasKondisi']);
            }]);
            $q->with(['trsHasGedung', 'trsHasRuangan']);
            $q->whereHas('trsHasStok2', function($q){
                $q->where('data_kategory_id',5);
            });
        }])->where('trs_id', $id)->first();

        return \view('transaksi/inventaris.detail', compact('details'));
    }


    public function tambah(Request $request)
    {
        // $getKodeTrs = '';
        $dataInv = StokModels::where('data_status_id',1)->where('data_jumlah', '>', 0)->where('data_kategory_id',5)->get();

        $dataPegawai = PegawaiModels::get();
        $gedung = GedungModels::get();
        $ruangan = RuanganModels::get();
        $countTrs = TransaksiDataModel::all()->count()+1;
        $getKodeTrs = 'TRS-INV-' . $countTrs .'';

        
        return \view('transaksi/inventaris.tambah', \compact('dataPegawai','gedung','ruangan' ,'dataInv', 'getKodeTrs'));
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
        $tgl = date("Y-m-d", strtotime($request->tgl) );

        $request->validate([
            'keterangan' => 'required',
            'tgl' => 'required',

        ],
        [
            'keterangan.required' => 'Keterangan tidak boleh kosong!',
            'tgl.required' => ' Tanggal tidak boleh kosong!',
        ]);

        $save = [
            'trs_kode'=> $request->id_trs_prkt,
            'trs_keterangan'=> $request->keterangan,
            'trs_date'=> $tgl,
        ];
        $trsAtk =TransaksiModels::create($save);
        // dd($trsAtk->trs_id);
        $trsId = $trsAtk->trs_id;
        $data2 = array();
        if ($request->inventaris) {
            foreach ($request->inventaris as $key => $data) {
                $data2[$key]['trs_id'] = $trsId;
                $data2[$key]['trs_detail_pegawai_id'] = $request->pegawai[$key];
                $data2[$key]['trs_detail_data_stok_id'] = $request->inventaris[$key];
                $data2[$key]['trs_detail_gedung_id'] = $request->gedung[$key];
                $data2[$key]['trs_detail_ruangan_id'] = $request->ruangan[$key];
                $data2[$key]['trs_detail_jumlah'] = $request->jml[$key];

                $stok = StokModels::whereIn('data_stok_id',[$request->inventaris[$key]]);
                $stok->decrement('data_jumlah', $request->jml[$key]);

                $stok = StokModels::whereIn('data_stok_id',[$request->inventaris[$key]]);
                $stok->increment('data_dipakai', $request->jml[$key]);
            }

            $save_detail = DB::table('trs_detail')->insert($data2);
        }

        $cek = Log::channel('database')->info($save_detail);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('tambah data transaksi inventaris' ,json_encode($query));

        Alert::success('Success', 'Data berhasil di Simpan');
        return redirect('transaksi_data/invtentaris_trans');
    }

    public function edit($id)
    {
        $detail = TransaksiModels::with(['trsDetail'=> function($q){
            $q->with(['trsHasPegawai2' => function($q){
                $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
            }]);
        }])->where('trs_id', $id)->first();

        $dataInv = StokModels::where('data_status_id',1)->where('data_jumlah', '>', 0)->where('data_kategory_id',5)->get();
        $dataPegawai = PegawaiModels::get();
        $gedung = GedungModels::get();
        $ruangan = RuanganModels::get();
        
        //  dd($trsInv->trsHasData);
        return \view('transaksi/inventaris.edit', \compact('dataInv', 'dataPegawai', 'detail', 'gedung', 'ruangan'));
    }

    public function update(Request $request , $id)
    {
        $tgl = date("Y-m-d", strtotime($request->tgl) );

        $request->validate([
            'keterangan' => 'required',
            'tgl' => 'required',

        ],
        [
            'keterangan.required' => 'Keterangan tidak boleh kosong!',
            'tgl.required' => ' Tanggal tidak boleh kosong!',
        ]);

        $save = [
            'trs_keterangan'=> $request->keterangan,
            'trs_date'=> $tgl,
        ];

        $updatedata = TransaksiModels::where('trs_id', $id)->update($save);


        $getOld = ($request->old)? $request->old : [];
        $checkFile = DetailTransaksi::where('trs_id', $id)->pluck('trs_detail_id');

            foreach ($checkFile as $key => $file) {
                if(!in_array($file, $getOld)){
                    $getDelete =DetailTransaksi::where('trs_detail_id',$file)->first();
                       
                        $getDelete->delete();
                    }
                }  

                $data2 = array();
                if ($request->inventaris_insert) {
                    foreach ($request->inventaris_insert as $key => $data) {
                        $data2[$key]['trs_id'] = $id;
                        $data2[$key]['trs_detail_pegawai_id'] = $request->pegawai_insert[$key];
                        $data2[$key]['trs_detail_data_stok_id'] = $request->inventaris_insert[$key];
                        $data2[$key]['trs_detail_gedung_id'] = $request->gedung_insert[$key];
                        $data2[$key]['trs_detail_ruangan_id'] = $request->ruangan_insert[$key];
                        $data2[$key]['trs_detail_jumlah'] = $request->jml_insert[$key];
        
                        $stok = StokModels::whereIn('data_stok_id',[$request->inventaris_insert[$key]]);
                        $stok->decrement('data_jumlah', $request->jml_insert[$key]);
        
                        $stok = StokModels::whereIn('data_stok_id',[$request->inventaris_insert[$key]]);
                        $stok->increment('data_dipakai', $request->jml_insert[$key]);
                    }
        
                    $save_detail = DB::table('trs_detail')->insert($data2);
                }

        $cek = Log::channel('database')->info($updatedata);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('update data transaksi Inventaris' ,json_encode($query));

        Alert::success('Success', 'Data berhasil di Update');
        return redirect('transaksi_data/invtentaris_trans');
    }
}
