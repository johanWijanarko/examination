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
use App\Models\TransaksiModels;
use App\Models\PeminjamanModels;
use App\Models\TypeKtegoryModels;
use App\Models\DataKelompokModels;
use App\Models\TransaksiDataModel;
use Illuminate\Support\Facades\DB;
use App\Models\DataManajemenModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class PeminjamanController extends Controller
{
    public function index(){
        return \view('transaksi.peminjaman/index');
    }

    public function getDataPinjaman(){
        $getDataPinjaman = PeminjamanModels::with(['peminjamanHasObjek', 'peminjamanHasPegawai', 'peminjamanHasGedung', 'peminjamanHasRuangan', 'peminjamanHasType'])->orderBy('peminjaman_id', 'desc')->get();

        return DataTables::of($getDataPinjaman)
            // ->addColumn('actions', 'transaksi/perangkat.actions')
            ->addColumn('details_url', function(PeminjamanModels $dp) {
               if ($dp) {
                   $btn = '<button data-url="'.route("detailpinjam",['id'=>$dp->peminjaman_id]).'" data-toggle="tooltip" data-placement="top" title="Detail" class="btn btn-success mr-1 btn-sm cek">Detail</button>';
                    $btn = $btn.'<a href="'.route("editpinjam",['id'=>$dp->peminjaman_id]).'" class="edit btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit">Edit</a>';
                   return $btn;
                }
                return '';
            })
            ->addColumn('dataPinjam', function (PeminjamanModels $dp) {
                if ($dp->peminjamanHasType) {
                    return $dp->peminjamanHasType->nama_data_type;
                }
                return '';
            })
            ->addColumn('objek', function (PeminjamanModels $dt) {
                if ($dt->peminjamanHasObjek) {
                    return $dt->peminjamanHasObjek->data_name;
                }
                
                return '';
            })
             ->addColumn('pegawai', function (PeminjamanModels $dk) {
                if ($dk->peminjamanHasPegawai) {
                    return $dk->peminjamanHasPegawai->pegawai_name;
                }
                return '';
            })
            ->addColumn('tgl', function (PeminjamanModels $dk) {
                if ($dk->peminjaman_tanggal) {
                    return date('d-m-Y', strtotime($dk->peminjaman_tanggal));
                }
                return '';
            })
            ->rawColumns([ 'gedung', 'ruangan', 'dataPinjam', 'pegawai', 'details_url', 'objek', 'tgl'])
            ->addIndexColumn()
            ->make(true);
    }

    public function detailpinjaman(Request $request, $id)
    {
        $getDataPinjaman = PeminjamanModels::with(['peminjamanHasObjek'=> function($q){
            $q->with(['stokHasKondisi', 'stokHasMerk', 'stokHasSupplier']);
        }, 'peminjamanHasGedung', 'peminjamanHasRuangan'])->orderBy('peminjaman_id', 'desc')->where('peminjaman_id' ,$id)->get();
        // dd($getDataPinjaman);
        return DataTables::of($getDataPinjaman)
            ->addColumn('gedung', function (PeminjamanModels $dp) {
                if ($dp->peminjamanHasGedung) {
                    return $dp->peminjamanHasGedung->nama_data_gedung;
                }
                return '';
            })
            ->addColumn('ruangan', function (PeminjamanModels $dp) {
                if ($dp->peminjamanHasRuangan) {
                    return $dp->peminjamanHasRuangan->nama_data_ruangan;
                }
                return '';
            })
            ->addColumn('kondisi', function (PeminjamanModels $dt) {
                if ($dt->peminjamanHasObjek->stokHasKondisi) {
                    return $dt->peminjamanHasObjek->stokHasKondisi->nama_data_kondisi;
                }
                
                return '';
            })
            ->addColumn('merk', function (PeminjamanModels $dt) {
                if ($dt->peminjamanHasObjek->stokHasMerk) {
                    return $dt->peminjamanHasObjek->stokHasMerk->nama_data_merk;
                }
                
                return '';
            })
            ->addColumn('supp', function (PeminjamanModels $dt) {
                if ($dt->peminjamanHasObjek->stokHasSupplier) {
                    return $dt->peminjamanHasObjek->stokHasSupplier->supplier_name;
                }
                
                return '';
            })
            ->rawColumns([ 'gedung', 'ruangan', 'kondisi', 'merk', 'supp'])
            ->addIndexColumn()
            ->make(true);
    }
    public function tambah(Request $request)
    {
        // $getKodeTrs = '';
        $dataPerangkat = DataManajemenModels::where('data_manajemen_jumlah', '>', 0)->get();
        $dataPegawai = PegawaiModels::get();
        $type = TypeKtegoryModels::get();
        $gedung = GedungModels::get();
        $ruangan = RuanganModels::get();
        $countTrs = TransaksiDataModel::all()->count()+1;
        $getKodeTrs = 'TRS-PJM-' . $countTrs .'';

        
        return \view('transaksi/peminjaman.tambah', \compact('ruangan' ,'gedung' ,'dataPegawai','dataPerangkat', 'getKodeTrs', 'type'));
    }

    public function getObejkPeminjam(Request $request)
    {
        $getObejkPeminjam = StokModels::where('data_kategory_id', $request->id)
        ->orderBy('data_stok_id', 'desc')
        ->pluck('data_name', 'data_stok_id');
            
        return response()->json($getObejkPeminjam);
    }
    public function getPinjam(Request $request)
    {
        $getPinjam =StokModels::where('data_stok_id', $request->get('id'))->first();

         
        return response()->json($getPinjam);
            
    }

    public function getPegawai(Request $request)
    {
        $detailPegawai = PegawaiModels::with(['pegawaiHasBagian','pegawaiHasSubBagian'])->where('pegawai_id', $request->id)->first();
        return response()->json($detailPegawai);
    }
    public function save(Request $request)
    {
        $request->validate([
            'data_peminjaman' => 'required',
            'obj' => 'required',
            'jumlah_pinjam' => 'required',
            'pegawai' => 'required',
            'gedung' => 'required',
            'ruangan' => 'required',
            'tglPinjam' => 'required',
            'keterangan' => 'required',
            
        ],
        [
            'data_peminjaman.required' => 'Data Peminjam tidak boleh kosong!',
            'obj.required' => ' Objek Peminjaman tidak boleh kosong!',
            'jumlah_pinjam.required' => 'Jumlah Peminjaman tidak boleh kosong!',
            'pegawai.required' => 'Nama Pegawai tidak boleh kosong!',
            'gedung.required' => 'Gedung tidak boleh kosong!',
            'ruangan.required' => 'Ruangan tidak boleh kosong!',
            'tglPinjam.required' => 'Tanggal Pinjam tidak boleh kosong!',
            'keterangan.required' => 'Keterangan tidak boleh kosong!',
        ]);

        ///////////////////////////////////////////////////////////////////////

        $save_ = [
           
            'peminjaman_kode'=> $request->kode_pinjam,
            'peminjamanType'=> $request->data_peminjaman,
            'peminjaman_obejk_id'=> $request->obj,
            'peminjaman_pegawai_id'=> $request->pegawai,
            'peminjaman_gedung_id'=> $request->gedung,
            'peminjaman_ruangan_id'=> $request->ruangan,
            'peminjaman_keterangan'=> $request->keterangan,
            'peminjaman_tanggal'=> $request->tglPinjam,
            'peminjaman_pic_id'=> Auth::user()->id,
            'peminjaman_jumlah'=> $request->jumlah_pinjam,
            
        ];

        $savePinjam =PeminjamanModels::create($save_);

        $cek = Log::channel('database')->info($savePinjam);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('tambah transaksi peminjaman' ,json_encode($query));

        ///////////////////////////////////////////////////////////////////////

        $save = [
            'trs_kode'=> $request->kode_pinjam,
            'trs_keterangan'=> $request->keterangan,
            'trs_date'=> Carbon::today(),
        ];
        $pinjamtrs =TransaksiModels::create($save);

        $trsId = $pinjamtrs->trs_id;
        $saveTrs = [
            'trs_id' => $trsId,
            'trs_detail_pegawai_id' => $request->pegawai,
            'trs_detail_data_stok_id' => $request->obj,
            'trs_detail_gedung_id' => $request->gedung,
            'trs_detail_ruangan_id' => $request->ruangan,
            'trs_detail_jumlah' => $request->jumlah_pinjam,
            'trs_detail_status' => 2,
            'trs_detail_pinjam_id' => $savePinjam->peminjaman_id,
        ];
        $saveTransaksi =DetailTransaksi::create($saveTrs);
        
       
        if($request->data_peminjaman == 3){
            $product =  StokModels::where('data_stok_id',$request->jumlah_pinjam);
            $product->increment('data_dipakai', $request->jumlah_pinjam);
            $product->decrement('data_jumlah', $request->jumlah_pinjam);
        }elseif($request->data_peminjaman == 4) {
            $product =  StokModels::where('data_stok_id',$request->jumlah_pinjam);
            $product->increment('data_dipakai', $request->jumlah_pinjam);
            $product->decrement('data_jumlah', $request->jumlah_pinjam);
        }elseif($request->data_peminjaman == 5) {
            $product =  StokModels::where('data_stok_id',$request->jumlah_pinjam);
            $product->increment('data_dipakai', $request->jumlah_pinjam);
            $product->decrement('data_jumlah', $request->jumlah_pinjam);
        }


        Alert::success('Success', 'Data berhasil di Simpan');
        return redirect('transaksi_data/peminjaman');
    }

    public function edit(Request $request, $id)
    {
        $getDataPinjaman = PeminjamanModels::with(['peminjamanHasObjek'=> function($q){
            $q->with(['stokHasKondisi', 'stokHasMerk', 'stokHasSupplier']);
        }, 'peminjamanHasPegawai','pinjamHasTrsDetail'])->orderBy('peminjaman_id', 'desc')->where('peminjaman_id',$id)->first();


        $getObejkPeminjam = StokModels::where('data_jumlah', '>', 0)->where('data_stok_id', $getDataPinjaman->peminjaman_obejk_id)->get();
        $dataPegawai = PegawaiModels::get();
        
        $type = TypeKtegoryModels::get();
        $gedung = GedungModels::get();
        $ruangan = RuanganModels::get();

        // dd($getDataPinjaman);
        return \view('transaksi/peminjaman.edit', \compact('ruangan' ,'gedung' ,'dataPegawai','getObejkPeminjam', 'getDataPinjaman', 'type'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            
            'pegawai' => 'required',
            'gedung' => 'required',
            'ruangan' => 'required',
            'tglPinjam' => 'required',
            'keterangan' => 'required',
            
        ],
        [
            
           
            'pegawai.required' => 'Nama Pegawai tidak boleh kosong!',
            'gedung.required' => 'Gedung tidak boleh kosong!',
            'ruangan.required' => 'Ruangan tidak boleh kosong!',
            'kelompok.required' => 'Kelompok tidak boleh kosong!',
            'tglPinjam.required' => 'Tanggal Pinjam tidak boleh kosong!',
            'keterangan.required' => 'Keterangan tidak boleh kosong!',
        ]);

        $save = [

            'peminjaman_pegawai_id'=> $request->pegawai,
            'peminjaman_gedung_id'=> $request->gedung,
            'peminjaman_ruangan_id'=> $request->ruangan,
            'peminjaman_keterangan'=> $request->keterangan,
            'peminjaman_tanggal'=> $request->tglPinjam,
            'peminjaman_pic_id'=> Auth::user()->id,
           
            
        ];
        $update =PeminjamanModels::where('peminjaman_id', $id)->update($save);

        $saveTrs = [
            'trs_detail_pegawai_id' => $request->pegawai,
            'trs_detail_gedung_id' => $request->gedung,
            'trs_detail_ruangan_id' => $request->ruangan,
        ];
        $saveTransaksi =DetailTransaksi::where('trs_detail_id', $request->trs_detail_id)->update($saveTrs);

        $save_ = [
            'trs_keterangan'=> $request->keterangan,
            'trs_date'=> Carbon::today(),
        ];
        $pinjamtrs =TransaksiModels::where('trs_id', $request->trs_id)->update($save_);

        $cek = Log::channel('database')->info($update);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('update transaksi peminjaman' ,json_encode($query));

        Alert::success('Success', 'Data berhasil di Simpan');
        return redirect('transaksi_data/peminjaman');
    }
}
