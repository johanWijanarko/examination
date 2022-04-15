<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\StokModels;
use App\Models\GedungModels;
use Illuminate\Http\Request;
use App\Models\KondisiModels;
use App\Models\PegawaiModels;
use App\Models\RuanganModels;
use App\Models\DetailTransaksi;
use App\Models\TransaksiModels;
use App\Models\TypeKtegoryModels;
use App\Models\PengembalianModels;
use App\Models\TransaksiDataModel;
use Illuminate\Support\Facades\DB;
use App\Models\DataManajemenModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class PengembalianController extends Controller
{
    public function index(Request $request)
    {
        return \view('transaksi/pengembalian.index');
    }

    public function tambah()
    {
        $dataPegawai = PegawaiModels::get();
        $datakondisi = KondisiModels::get();
        $gedung = GedungModels::get();
        $ruangan = RuanganModels::get();
        $type = TypeKtegoryModels::get();
        return \view('transaksi/pengembalian.tambah', \compact('dataPegawai', 'datakondisi','gedung', 'ruangan', 'type'));
    }

    public function getDataPengembalian(Request $request)
    {

        $datakembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek', 'kembaliHasPegawai' => function($q){
            $q->with('pegawaiHasBagian');
            $q->with('pegawaiHasSubBagian');
        }, 'kembaliHasKondisiSkrg', 'kembaliHasKondisiSblm'])->get();

        // dd($datakembali);
        return DataTables::of($datakembali)
            ->addColumn('details_url', function(PengembalianModels $dp) {
               if ($dp) {

                $btn ='<a data-toggle="modal" id="smallButton2"  data-target="#smallModal2" data-attr="'.route("detailkembali",['id'=>$dp->pengembalian_id]).'" data-placement="top" title="Approve"  class="edit btn btn-warning btn-sm" >Detail</a>';

                    if($dp->pengembalian_status == 1){

                        $btn = $btn.'<a href="'.route("editKembali",['id'=>$dp->pengembalian_id, 'detail'=>$dp->pengembalian_trs_detail_id]).'" class="edit btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Edit">Edit</a>';

                        $btn =$btn.'<a data-toggle="modal" id="smallButton"  data-target="#smallModal" data-attr="'.route("confrimApprove",['id'=>$dp->pengembalian_id]).'" data-placement="top" title="Approve"  class="edit btn btn-primary btn-sm" >Approve</a>';
                    return $btn;
                    }
                    return $btn;
                }
                return '';
            })
            ->addColumn('perangkat', function (PengembalianModels $dp) {
                if ($dp->kembaliHasType) {
                    return $dp->kembaliHasType->nama_data_type;
                }
                return '';
            })
            ->addColumn('objek', function (PengembalianModels $dt) {
                if ($dt->kembaliHasObjek) {
                    return $dt->kembaliHasObjek->data_name;
                }

                return '';
            })
            ->addColumn('pegawai', function (PengembalianModels $dk) {
                if ($dk->kembaliHasPegawai) {
                    return $dk->kembaliHasPegawai->pegawai_name;
                }
                return '';
            })
            ->addColumn('bagian', function (PengembalianModels $dg) {
               if ($dg->kembaliHasPegawai->pegawaiHasBagian) {
                    return $dg->kembaliHasPegawai->pegawaiHasBagian->nama_bagian;
                }
                return '';
            })
            ->addColumn('subbagian', function (PengembalianModels $dg) {
                if ($dg->kembaliHasPegawai->pegawaiHasSubBagian) {
                    return $dg->kembaliHasPegawai->pegawaiHasSubBagian->sub_bagian_nama;
                }
                return '';
            })
            ->addColumn('konseb', function (PengembalianModels $dg) {
                if ($dg->kembaliHasKondisiSblm) {
                    return $dg->kembaliHasKondisiSblm->nama_data_kondisi;
                }
                return '';
            })
            ->addColumn('konsek', function (PengembalianModels $dg) {
                if ($dg->kembaliHasKondisiSkrg) {
                    return $dg->kembaliHasKondisiSkrg->nama_data_kondisi;
                }
                return '';
            })
            ->addColumn('ket', function (PengembalianModels $dg) {
                if ($dg->pengembalian_keterangan) {
                    return $dg->pengembalian_keterangan;
                }
                return '';
            })
            ->addColumn('status', function (PengembalianModels $dp) {
                $status = [
                    '1' => 'Dipakai',
                    '2' => 'Dipinjam',
                    '3' => 'Sedang diperbaiki',
                    '4' => 'Dikembalikan',
                    '5' => 'Dimutasi',
                    '6' => 'Selesai diperbaikai',
                    '7' => 'Tidak dapat diperbaik',
                ];
                if ($dp->pengembalian_status_pinjam) {

                       return  $status[$dp->pengembalian_status_pinjam];
                    }
                return '';
            })
            ->rawColumns(['details_url'])
            ->addIndexColumn()
            ->make(true);
    }
    public function detail($id)
    {
        $datakembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek', 'kembaliHasPegawai' => function($q){
            $q->with('pegawaiHasBagian');
            $q->with('pegawaiHasSubBagian');
        }, 'kembaliHasKondisiSkrg', 'kembaliHasKondisiSblm'])
        ->where('pengembalian_id', $id)->first();

        // dd($datakembali);
        return \view('transaksi/pengembalian.detail', compact('datakembali'));

    }
    public function save(Request $request){
        // dd($request->all());
        $data = explode(":", $request->pegawai);
        $pegawai_id = (int)$data[0];
        $stok_id = (int)$data[1];

        $request->validate([
            'data_pengembalian' => 'required',
            'obj' => 'required',
            'pegawai' => 'required',
            'kondisi' => 'required',
        ],
        [
            'data_pengembalian.required' => 'Data Pengembalian tidak boleh kosong!',
            'obj.required' => ' Objek Mutasi tidak boleh kosong!',
            'pegawai.required' => 'Pegawai Sekarang tidak boleh kosong!',
            'kondisi.required' => 'Kondisi tidak boleh kosong!',
        ]);

        $save = [
            'pengembalian_data_id'=> $request->data_pengembalian,
            'pengembalian_obejk_id'=> $request->obj,
            'pengembalian_pegawai_id'=> $pegawai_id,
            'pengembalian_kondisi_sebelum_id'=> $request->kds_detail_id,
            'pengembalian_kondisi_sekarang_id'=> $request->kondisi,
            'pengembalian_keterangan'=> $request->ketkembali,
            'pengembalian_trs_detail_id'=> $request->trs_detail_id,
            'pengembalian_pic_id'=> Auth::user()->id,
            'pengembalian_tgl'=> Carbon::today(),
            'pengembalian_jumlah' =>$request->jumlah_kembali,

        ];
        $kembali =PengembalianModels::create($save);

        $cek = Log::channel('database')->info($kembali);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('tambah transaksi pengembalian' ,json_encode($query));


        // $product = StokModels::find($request->obj);
        // $product->decrement('data_dipakai', $request->jumlah_kembali);
        // $product->increment('data_jumlah', $request->jumlah_kembali);


        Alert::success('Success', 'Data berhasil di Simpan');
        return redirect('transaksi_data/pengembalian');
    }

    public function confrimApprove($id){
        $getData = PengembalianModels::find($id);
        // dd($getData);
        return \view('transaksi/pengembalian.approve',compact('getData'));
    }


    public function approve(Request $request,$id, $trs_id ){
          // update transaksi
        //   dd($trs_id);
          $detailTrs = DetailTransaksi::find($trs_id);
          $jumlahPinjam = $detailTrs->trs_detail_jumlah;
          $updateStok = $detailTrs->trs_detail_data_stok_id;

          $getStokdata = StokModels::where('data_stok_id', $updateStok)->first();

          $jmlKembali = PengembalianModels::find($id);
          $jml = $jmlKembali->pengembalian_jumlah;

          if($jumlahPinjam > 0 ){
              $detailTrs->decrement('trs_detail_jumlah', $jml);
              $getStokdata->decrement('data_dipakai', $jml);
              $getStokdata->increment('data_jumlah', $jml);
          }

          $detailTrs_ = DetailTransaksi::find($trs_id);
          $jumlahPinjam_ = $detailTrs_->trs_detail_jumlah;
          if($jumlahPinjam_ == 0){
              $kembali= [
                  'trs_detail_status'=>4
              ];
              $updatetrans =DetailTransaksi::where('trs_detail_id', $request->trs_detail_id)->update($kembali);
          }

        $kembaliUpdate =PengembalianModels::where('pengembalian_id', $id)->update([ 'pengembalian_status'=> 0 ,
        'pengembalian_status_pinjam' => 4,
    ]);

        Alert::success('Success', 'Data berhasil di Approve');
        return redirect('transaksi_data/pengembalian');
    }

    public function getObejkKembali(Request $request)
    {

        $getObejkKembali = StokModels::where('data_kategory_id', $request->id)
        ->orderBy('data_stok_id', 'desc')
        ->pluck('data_name', 'data_stok_id');
        return response()->json($getObejkKembali);
    }

    public function getPegawiKembali(Request $request)
    {
        $getPegawiMutasi = DetailTransaksi ::with(['trsHasPegawai2','trsHasStok2'=> function($q){
            $q->with(['stokHasKondisi']);
        }])
        ->where('trs_detail_data_stok_id', $request->id)->where('trs_detail_status','!=', 4)
        ->orderBy('trs_detail_id', 'asc')->get()
        // ->map('trsHasPegawai.pegawai_name', 'trsHasPegawai.pegawai_id');
        ->map(function ($p){
            return [
                'trs_id' => $p->trs_detail_id,
                'stok_id' => $p->trs_detail_data_stok_id,
                'kondisi' => $p->trsHasStok2->stokHasKondisi->nama_data_kondisi,
                'kondisi_id' => $p->trsHasStok2->stokHasKondisi->data_kondisi_id,
                'id_peg' => $p->trsHasPegawai2->pegawai_id,
                'pegawe_name' => $p->trsHasPegawai2->pegawai_name,
            ];
        });

            // dd($getPegawiMutasi);
        return response()->json($getPegawiMutasi);
    }

    public function getRekapKembali(Request $request)
    {
        // dd($request->all());
        $data = explode(":", $request->id);
        $dataStok = (int)$data[1];
        $getRekapMutasi_ = DetailTransaksi ::with(['trsHasStok2'=> function($q){
            $q->with(['stokHasKondisi']);
        }])
        // ->where('trs_id', $trs_id)
        ->where('trs_detail_data_stok_id',$dataStok)
        ->first();

       return response()->json($getRekapMutasi_);

    }

    public function edit($id, $detail){

        $datakondisi = KondisiModels::get();
        $type = TypeKtegoryModels::get();

        $datakembali = PengembalianModels::orderBy('pengembalian_id', 'desc')->with(['kembaliHasObjek', 'kembaliHasPegawai', 'kembaliHasKondisiSkrg', 'kembaliHasKondisiSblm','kembaliHasTrs'])->where('pengembalian_id', $id)->first();

        $getpegawai = DetailTransaksi::with(['trsHasPegawai2'])->where('trs_detail_data_stok_id',$datakembali->pengembalian_obejk_id)->get();
        // dd($getpegawai);
        $objekMutasi = StokModels::where('data_kategory_id', $datakembali->pengembalian_data_id)->get();
        // dd($datakembali);
        return \view('transaksi/pengembalian.edit', \compact('datakondisi', 'datakembali', 'objekMutasi', 'type', 'getpegawai'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());

        $request->validate([
            'data_pengembalian' => 'required',
            'obj' => 'required',
            'pegawai' => 'required',
            'kondisi' => 'required',
        ],
        [
            'data_pengembalian.required' => 'Data Pengembalian tidak boleh kosong!',
            'obj.required' => ' Objek Mutasi tidak boleh kosong!',
            'pegawai.required' => 'Pegawai Sekarang tidak boleh kosong!',
            'kondisi.required' => 'Kondisi tidak boleh kosong!',
        ]);

        $save = [
            'pengembalian_data_id'=> $request->data_pengembalian,
            'pengembalian_obejk_id'=> $request->obj,
            'pengembalian_pegawai_id'=> $request->pegawai,
            'pengembalian_kondisi_sebelum_id'=> $request->kds_detail_id,
            'pengembalian_kondisi_sekarang_id'=> $request->kondisi,
            'pengembalian_keterangan'=> $request->ketkembali,
            'pengembalian_trs_detail_id'=> $request->trs_detail_id,
            'pengembalian_pic_id'=> Auth::user()->id,
            'pengembalian_tgl'=> Carbon::today(),
            'pengembalian_jumlah' =>$request->jumlah_kembali,

        ];

        $kembali =PengembalianModels::where('pengembalian_id', $id)->update($save);

        $cek = \Log::channel('database')->info($kembali);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('update transaksi pengembalian' ,json_encode($query));

        Alert::success('Success', 'Data berhasil di Simpan');
        return redirect('transaksi_data/pengembalian');

    }

}
