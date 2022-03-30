<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\GedungModels;
use Illuminate\Http\Request;
use App\Models\KondisiModels;
use App\Models\PegawaiModels;
use App\Models\RuanganModels;
use App\Models\DataMerkModels;
use App\Models\SupplierModels;
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
        $getDataPinjaman = PeminjamanModels::with(['peminjamanHasObjek'=> function($q){
            $q->with('manajemenHasKondisi');
        }, 'peminjamanHasPegawai', 'peminjamanHasGedung', 'peminjamanHasRuangan'])->orderBy('peminjaman_id', 'desc')->get();

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
                $jenisKembali = [ 
                    '1' => 'Perangkat',
                    '2' => 'Aplikasi',
                    '3' => 'Peralatan Kantor',
                    '4' => 'Inventaris'
                ];
                
                if ($dp->peminjaman_data_id) {
                    return $jenisKembali[$dp->peminjaman_data_id];
                }
                return '';
            })
            ->addColumn('objek', function (PeminjamanModels $dt) {
                if ($dt->peminjamanHasObjek) {
                    return $dt->peminjamanHasObjek->data_manajemen_name;
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
            $q->with(['manajemenHasKondisi', 'manajemenHasMerk', 'manajemenHasType', 'manajemenHasSupplier']);
        }, 'peminjamanHasGedung', 'peminjamanHasRuangan'])->orderBy('peminjaman_id', 'desc')->where('peminjaman_id' ,$id)->get();
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
                if ($dt->peminjamanHasObjek->manajemenHasKondisi) {
                    return $dt->peminjamanHasObjek->manajemenHasKondisi->nama_data_kondisi;
                }
                
                return '';
            })
            ->addColumn('merk', function (PeminjamanModels $dt) {
                if ($dt->peminjamanHasObjek->manajemenHasMerk) {
                    return $dt->peminjamanHasObjek->manajemenHasMerk->nama_data_merk;
                }
                
                return '';
            })
             ->addColumn('type', function (PeminjamanModels $dt) {
                if ($dt->peminjamanHasObjek->manajemenHasType) {
                    return $dt->peminjamanHasObjek->manajemenHasType->nama_data_type;
                }
                
                return '';
            })
            ->addColumn('supp', function (PeminjamanModels $dt) {
                if ($dt->peminjamanHasObjek->manajemenHasSupplier) {
                    return $dt->peminjamanHasObjek->manajemenHasSupplier->supplier_name;
                }
                
                return '';
            })
            ->rawColumns([ 'gedung', 'ruangan', 'kondisi', 'merk', 'type', 'supp'])
            ->addIndexColumn()
            ->make(true);
    }
    public function tambah(Request $request)
    {
        // $getKodeTrs = '';
        $dataPerangkat = DataManajemenModels::where('data_manajemen_jumlah', '>', 0)->get();
        $dataPegawai = PegawaiModels::get();
        
        $kelompok = DataKelompokModels::get();
        $gedung = GedungModels::get();
        $ruangan = RuanganModels::get();
        $countTrs = TransaksiDataModel::all()->count()+1;
        $getKodeTrs = 'TRS-PJM-' . $countTrs .'';

        
        return \view('transaksi/peminjaman.tambah', \compact('ruangan' ,'gedung' ,'dataPegawai','dataPerangkat', 'kelompok', 'getKodeTrs'));
    }

    public function getObejkPeminjam(Request $request)
    {
        $getObejkPeminjam = DataManajemenModels::where('data_manajemen_kode_id', $request->id)
        ->orderBy('data_manajemen_name', 'desc')
        ->pluck('data_manajemen_name', 'data_manajemen_id');
            
        return response()->json($getObejkPeminjam);
    }
    public function getPinjam(Request $request)
    {
        $getPinjam =DataManajemenModels::where('data_manajemen_id', $request->get('id'))->first();
        
        $getMerk = DataMerkModels::select('nama_data_merk')->where('data_merk_id', $getPinjam->data_manajemen_merk_id)->first();
        $typeKategory = TypeKtegoryModels::select('nama_data_type')->where('data_type_id', $getPinjam->data_manajemen_type_id)->first();
        $kondisi = KondisiModels::select('nama_data_kondisi','data_kondisi_id')->where('data_kondisi_id', $getPinjam->data_manajemen_kondisi_id)->first();
        $gedung = GedungModels::select('nama_data_gedung')->where('data_gedung_id', $getPinjam->data_manajemen_gedung_id)->first();
        $ruangan = RuanganModels::select('nama_data_ruangan')->where('data_ruangan_id', $getPinjam->data_manajemen_ruangan_id)->first();
        $supplier = SupplierModels::select('supplier_name')->where('supplier_id', $getPinjam->data_manajemen_supplier_id)->first();

         return response()->json([
            'getMerk' => $getMerk,
            'typeKategory' => $typeKategory,
            'kondisi' => $kondisi,
            'gedung' => $gedung,
            'ruangan' => $ruangan,
            'supplier' => $supplier,
            'getPinjam' => $getPinjam
        ]);
            
    }

    public function getPegawai(Request $request)
    {
        $detailPegawai = PegawaiModels::with(['pegawaiHasBagian','pegawaiHasSubBagian'])->where('pegawai_id', $request->id)->first();
        return response()->json($detailPegawai);
    }
    public function save(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'data_peminjaman' => 'required',
            'obj' => 'required',
            'jumlah_pinjam' => 'required',
            'pegawai' => 'required',
            'gedung' => 'required',
            'ruangan' => 'required',
            'kelompok' => 'required',
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
            'kelompok.required' => 'Kelompok tidak boleh kosong!',
            'tglPinjam.required' => 'Tanggal Pinjam tidak boleh kosong!',
            'keterangan.required' => 'Keterangan tidak boleh kosong!',
        ]);

        ///////////////////////////////////////////////////////////////////////

        $save = [
           
            'peminjaman_kode'=> $request->kode_pinjam,
            'peminjaman_data_id'=> $request->data_peminjaman,
            'peminjaman_obejk_id'=> $request->obj,
            'peminjaman_pegawai_id'=> $request->pegawai,
            'peminjaman_gedung_id'=> $request->gedung,
            'peminjaman_ruangan_id'=> $request->ruangan,
            'peminjaman_kelompok_id'=> $request->kelompok,
            'peminjaman_keterangan'=> $request->keterangan,
            'peminjaman_tanggal'=> $request->tglPinjam,
            'peminjaman_pic_id'=> Auth::user()->id,
            'peminjaman_jumlah'=> $request->jumlah_pinjam,
            
        ];

        $savetrsAplikasi =PeminjamanModels::create($save);

        $cek = \Log::channel('database')->info($savetrsAplikasi);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('tambah transaksi peminjaman' ,json_encode($query));

        ///////////////////////////////////////////////////////////////////////

        $savetrs = [
            'trs_data_id'=> $request->obj,
            'trs_kode'=> $request->kode_pinjam,
            'trs_jenis_id'=> $request->data_peminjaman,
            'trs_name'=> $request->keterangan,
            'trs_pegawai_id'=> $request->pegawai,
            'trs_bagian_id'=> $request->bagian_,
            'trs_ruangan_id'=> $request->ruangan,
            'trs_sub_bagian_id'=> $request->subBagian_,
            'trs_gedung_id'=> $request->gedung,
            'trs_kelompok_id'=> $request->kelompok,
            'trs_kondisi_id'=> $request->kondisi_id,
            'trs_pic_id'=> Auth::user()->id,
            'trs_status_id'=> 2,
            'trs_date'=> Carbon::today(),
            
            
        ];
        
       
        if($request->data_peminjaman == 1){
            $product = DataManajemenModels::find($request->obj);
            $product->increment('data_manajemen_jumlah_pinjam', $request->jumlah_pinjam);
            $product->decrement('data_manajemen_jumlah', $request->jumlah_pinjam);
        }elseif($request->data_peminjaman == 3) {
            $product = DataManajemenModels::find($request->obj);
            $product->increment('data_manajemen_jumlah_pinjam', $request->jumlah_pinjam);
            $product->decrement('data_manajemen_jumlah', $request->jumlah_pinjam);
        }elseif($request->data_peminjaman == 4) {
            $product = DataManajemenModels::find($request->obj);
            $product->increment('data_manajemen_jumlah_pinjam', $request->jumlah_pinjam);
            $product->decrement('data_manajemen_jumlah', $request->jumlah_pinjam);
        }


        $savetrsAplikasi =TransaksiDataModel::create($savetrs);
        Alert::success('Success', 'Data berhasil di Simpan');
        return redirect('transaksi_data/peminjaman');
    }

    public function edit(Request $request, $id)
    {
        $getDataPinjaman = PeminjamanModels::with(['peminjamanHasObjek'=> function($q){
            $q->with('manajemenHasKondisi');
            $q->with('manajemenHasMerk');
            $q->with('manajemenHasType');
            $q->with('manajemenHasSupplier');
        }, 'peminjamanHasPegawai'=>function($q){
            $q->with(['pegawaiHasBagian', 'pegawaiHasSubBagian']);
        }])->orderBy('peminjaman_id', 'desc')->where('peminjaman_id',$id)->first();


        $getObejkPeminjam = DataManajemenModels::where('data_manajemen_jumlah', '>', 0)->where('data_manajemen_kode_id', $getDataPinjaman->peminjaman_data_id)->get();
        $dataPegawai = PegawaiModels::get();
        
        $kelompok = DataKelompokModels::get();
        $gedung = GedungModels::get();
        $ruangan = RuanganModels::get();

        // dd($getDataPinjaman);
        return \view('transaksi/peminjaman.edit', \compact('ruangan' ,'gedung' ,'dataPegawai','getObejkPeminjam', 'kelompok', 'getDataPinjaman'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'data_peminjaman' => 'required',
            'obj' => 'required',
            'jumlah_pinjam' => 'required',
            'pegawai' => 'required',
            'gedung' => 'required',
            'ruangan' => 'required',
            'kelompok' => 'required',
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
            'kelompok.required' => 'Kelompok tidak boleh kosong!',
            'tglPinjam.required' => 'Tanggal Pinjam tidak boleh kosong!',
            'keterangan.required' => 'Keterangan tidak boleh kosong!',
        ]);

        $save = [
           
            // 'peminjaman_kode'=> $request->kode_pinjam,
            'peminjaman_data_id'=> $request->data_peminjaman,
            'peminjaman_obejk_id'=> $request->obj,
            'peminjaman_pegawai_id'=> $request->pegawai,
            'peminjaman_gedung_id'=> $request->gedung,
            'peminjaman_ruangan_id'=> $request->ruangan,
            'peminjaman_kelompok_id'=> $request->kelompok,
            'peminjaman_keterangan'=> $request->keterangan,
            'peminjaman_tanggal'=> $request->tglPinjam,
            'peminjaman_pic_id'=> Auth::user()->id,
            'peminjaman_jumlah'=> $request->jumlah_pinjam,
            
        ];
        $update =PeminjamanModels::where('peminjaman_id', $id)->update($save);

        $cek = \Log::channel('database')->info($update);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('update transaksi peminjaman' ,json_encode($query));

        Alert::success('Success', 'Data berhasil di Simpan');
        return redirect('transaksi_data/peminjaman');
    }
}
