<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParKompetensi;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ParPelatihanCtr extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->cari;
        $komp = ParKompetensi::where('kompetensi_del_st', 1)
            ->when($request->cari, function ($q) use ($request) {
                $q->where('kompetensi_name', 'like', '%' . $request->cari . '%');
                $q->orWhere('kompetensi_desc', 'like', '%' . $request->cari . '%');
            })
            ->paginate(10);
        // dd($komp);
        return view('parameter/par_pegawai/pelatihan.index', compact('komp'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }
    public function tambah()
    {
        return view('parameter/par_pegawai/pelatihan.tambah');
    }

    public function save(Request $request)
    {
        // dd($request->all());
        DB::connection()->enableQueryLog();
        $this->validate($request, [
            'pelatihan' => 'required',
            'keterangan' => 'required'
        ]);

        $save = [
            'kompetensi_name' => $request->pelatihan,
            'kompetensi_desc' => $request->keterangan,
            'kompetensi_del_st' => 1
        ];
        // dd($save);
        $ParKompetensi = ParKompetensi::create($save);
        $keterangan = 'menambahkan Pelatihan dengan ID '. $ParKompetensi->kompetensi_id. ', keterangan '.$request->pelatihan;
        
        $cek = \Log::channel('database')->info($ParKompetensi);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('tambah Pelatihan',$keterangan ,json_encode($query ));
        // $this->save_log('tambah Pelatihan',$keterangan ,$ParKompetensi );

        Alert::success('Success', 'Data berhasil di Simpan');
        return redirect('parameter/pegawaispi/p_pelatihan');
    }

    public function edit($id)
    {
        $getData = ParKompetensi::where('kompetensi_id', $id)->first();
        return view('parameter/par_pegawai/pelatihan.edit', compact('getData'));
    }

    public function update(Request $request, $id)
    {
        DB::connection()->enableQueryLog();
        $this->validate($request, [
            'pelatihan' => 'required',
            'keterangan' => 'required'
        ]);

        $update = [
            'kompetensi_name' => $request->pelatihan,
            'kompetensi_desc' => $request->keterangan,
        ];
        $ketKompetensi = ParKompetensi::where('kompetensi_id', $id)->first();
        $ParKompetensi = ParKompetensi::where('kompetensi_id', $id)->update($update);
        $keterangan = 'Update Pelatihan dengan ID '. $id. ', dari '.$ketKompetensi->kompetensi_name.', '.$ketKompetensi->kompetensi_desc. ' menjadi '.$request->pelatihan. ', '.$request->keterangan;
        
        $cek = \Log::channel('database')->info($ParKompetensi);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('Update Pelatihan',$keterangan ,json_encode($query ));
        // $this->save_log('Update Pelatihan',$keterangan ,$ParKompetensi );

        Alert::success('Success', 'Data berhasil di Update');
        return redirect('parameter/pegawaispi/p_pelatihan');
    }

    public function confrimDel($id)
    {
        $getData = ParKompetensi::where('kompetensi_id', $id)->first();
        return view('parameter/par_pegawai/pelatihan.delete', compact('getData'));
    }

    public function delete($id)
    {
        DB::connection()->enableQueryLog();
        $delete = [
            'kompetensi_del_st' => 0
        ];
        $ParKompetensi = ParKompetensi::where('kompetensi_id', $id)->update($delete);
        $keterangan = 'Delete Pelatihan dengan ID '. $id;

        $cek = \Log::channel('database')->info($ParKompetensi);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('Delete Pelatihan',$keterangan ,json_encode($query ));
        // $this->save_log('Delete Pelatihan',$keterangan ,$ParKompetensi );

        Alert::success('Success', 'Data berhasil di Delete');
        return redirect('parameter/pegawaispi/p_pelatihan');
    }
}
