<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\StokModels;
use App\Models\GedungModels;
use Illuminate\Http\Request;
use App\Models\KondisiModels;
use App\Models\PegawaiModels;
use App\Models\RuanganModels;
use App\Models\DataMerkModels;
use App\Models\SupplierModels;
use App\Models\DetailTransaksi;
use App\Models\SubBagianModels;
// use App\Models\TransaksiDataModel;
use App\Models\TransaksiModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class TransaksiAplikasiController extends Controller
{
    public function index()
    {
        $trsDetail = TransaksiModels::whereHas('trsDetail', function($q){
            $q->whereHas('trsHasPegawai2');
            $q->whereHas('trsHasStok2', function($q){
                $q->where('data_kategory_id',13);
            });
        })
        ->orderBy('trs_id', 'asc')->where('trs_status_id',1)
        ->get();
        // dd($trsDetail);
        return \view('transaksi/aplikasi.index');
    }

    public function getTrsaplikasi()
    {
        $trsDetail = TransaksiModels::whereHas('trsDetail', function($q){
            $q->whereHas('trsHasPegawai2');
            $q->whereHas('trsHasStok2', function($q){
                $q->where('data_kategory_id',13);
            });
        })
        ->orderBy('trs_id', 'asc')->where('trs_status_id',1)
        ->get();
        
        return DataTables::of($trsDetail)
        ->addColumn('details_url', function(TransaksiModels $dp) {
           if ($dp->trs_id) {
            $btn ='<a href="'.route("edit_trs_aplikasi",['id'=>$dp->trs_id]).'" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-sm btn-warning rounded-circle " ><i class="fas fa-edit"></i></i></a>';
            $btn =$btn.'<a data-toggle="modal" id="smallButton"  data-target="#smallModal" data-attr="'.route("detail_trs_aplikasi",['id'=>$dp->trs_id]).'" data-placement="top" title="Edit" class="btn btn-sm btn-success rounded-circle " ><i class="fas fa-eye"></i></a>';
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
                // return $dp->trsHasStok2->data_name;
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
                // return $dp->trsHasStok2->data_name;
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
 

    public function detail($id){
        
          $details = TransaksiModels::with(['trsDetail'=> function($q){
            $q->with(['trsHasPegawai2' => function($q){
                $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
            }, 'trsHasStok2'=> function ($q){
                $q->with(['stokHasMerk','stokHasKondisi']);
            }]);
            $q->with(['trsHasGedung', 'trsHasRuangan']);
            $q->whereHas('trsHasStok2', function($q){
                $q->where('data_kategory_id',4);
            });
        }])->where('trs_id', $id)->first();
        // $data = $details->first()->stokHasMerk;
        // dd($details);

        return view('transaksi/aplikasi.detail',compact('details'));
    }

    public function tambah(Request $request)
    {
        $dataStok = StokModels::where('data_status_id',1)->where('data_jumlah', '>', 0)->where('data_kategory_id',13)->get();

        $dataPegawai = PegawaiModels::get();
        $gedung = GedungModels::get();
        $ruangan = RuanganModels::get();
        $countTrs = TransaksiModels::all()->count()+1;
        $getKodeTrs = 'TRS-APL-' . $countTrs .'';

        return \view('transaksi/aplikasi.tambah', \compact('ruangan' ,'gedung' ,'dataPegawai','dataStok', 'getKodeTrs'));
    }

    public function getSubBagian(Request $request)
    {
        $subBagian = SubBagianModels::where('sub_bagian_bagian_id',$request->id)->get()
        ->map(function ($p){
            return [
                'id' => $p->sub_bagian_id,
                'nama' => $p->sub_bagian_nama,
            ];
        });
        return response()->json($subBagian);
    }
    public function gatAplikasi(Request $request)
    {
        $dataStok =StokModels::where('data_stok_id', $request->get('id'))->where('data_status_id',1)->first();

        $getMerk = DataMerkModels::select('nama_data_merk')->where('data_merk_id', $dataStok->data_merk_id)->first();
        $kondisi = KondisiModels::select('nama_data_kondisi','data_kondisi_id')->where('data_kondisi_id', $dataStok->data_kondisi_id)->first();
        $supplier = SupplierModels::select('supplier_name')->where('supplier_id', $dataStok->data_supplier_id)->first();

         return response()->json([
            'getMerk' => $getMerk,
            'kondisi' => $kondisi,
            'supplier' => $supplier,
            'dataStok' => $dataStok
        ]);

    }

    public function getPegawai(Request $request){
        $detailPegawai = PegawaiModels::with(['pegawaiHasBagian','pegawaiHasSubBagian'])->where('pegawai_id', $request->id)->first();
        return response()->json($detailPegawai);
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
        if ($request->perangkat) {
            foreach ($request->perangkat as $key => $data) {
                $data2[$key]['trs_id'] = $trsId;
                $data2[$key]['trs_detail_pegawai_id'] = $request->pegawai[$key];
                $data2[$key]['trs_detail_data_stok_id'] = $request->perangkat[$key];
                $data2[$key]['trs_detail_gedung_id'] = $request->gedung[$key];
                $data2[$key]['trs_detail_ruangan_id'] = $request->ruangan[$key];
                $data2[$key]['trs_detail_jumlah'] = $request->jml[$key];

                $stok = StokModels::whereIn('data_stok_id',[$request->perangkat[$key]]);
                $stok->decrement('data_jumlah', $request->jml[$key]);

                $stok = StokModels::whereIn('data_stok_id',[$request->perangkat[$key]]);
                $stok->increment('data_dipakai', $request->jml[$key]);
            }

            $save_detail = DB::table('trs_detail')->insert($data2);
        }

        $cek = Log::channel('database')->info($save_detail);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('tambah data transaksi atk' ,json_encode($query));

        Alert::success('Success', 'Data berhasil di Simpan');
        return redirect('transaksi_data/p_kantor_trans');
    }

    public function edit($id){

        // $trsPerangkat = TransaksiModels::with(['trsHasStok'=> function ($q){
        //     $q->with(['stokHasMerk','stokHasType','stokHasKondisi','stokHasSupplier']);
        // },'trsHasPegawai'=> function ($q){
        //     $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
        // },'trsHasGedung','trsHasRuangan','trsHasPic'])
        // ->orderBy('trs_id', 'asc')->where('trs_status_id',1)->where('trs_id', $id)
        //  ->whereHas('trsHasStok', function ($q){
        //     $q->where('data_kategory_id',13);
        // })->first();

        $detail = TransaksiModels::with(['trsDetail'=> function($q){
            $q->with(['trsHasPegawai2' => function($q){
                $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
            }]);
        }])->where('trs_id', $id)->first();

        $dataStok = StokModels::where('data_status_id',1)->where('data_jumlah', '>', 0)->where('data_kategory_id',3)->get();
        $dataPegawai = PegawaiModels::get();
        $gedung = GedungModels::get();
        $ruangan = RuanganModels::get();

        return \view('transaksi/aplikasi.edit', \compact('ruangan','gedung','detail', 'dataPegawai','dataStok'));
    }

    public function update(Request $request , $id){
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
                if ($request->perangkat_insert) {
                    foreach ($request->perangkat_insert as $key => $data) {
                        $data2[$key]['trs_id'] = $id;
                        $data2[$key]['trs_detail_pegawai_id'] = $request->pegawai_insert[$key];
                        $data2[$key]['trs_detail_data_stok_id'] = $request->perangkat_insert[$key];
                        $data2[$key]['trs_detail_gedung_id'] = $request->gedung_insert[$key];
                        $data2[$key]['trs_detail_ruangan_id'] = $request->ruangan_insert[$key];
                        $data2[$key]['trs_detail_jumlah'] = $request->jml_insert[$key];
        
                        $stok = StokModels::whereIn('data_stok_id',[$request->perangkat_insert[$key]]);
                        $stok->decrement('data_jumlah', $request->jml_insert[$key]);
        
                        $stok = StokModels::whereIn('data_stok_id',[$request->perangkat_insert[$key]]);
                        $stok->increment('data_dipakai', $request->jml_insert[$key]);
                    }
        
                    $save_detail = DB::table('trs_detail')->insert($data2);
                }

        $cek = Log::channel('database')->info($updatedata);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('update data transaksi perangkat' ,json_encode($query));

        Alert::success('Success', 'Data berhasil di Update');
        return redirect('transaksi_data/aplikasi_trans');
    }
}
