<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class ParamJabatan extends Controller
{
    public function index()
    {
        return view('parameter/par_pegawai/jabatan.index');
    }
    public function getjabatan()
    {
        $jabatan = Jabatan::where('jenis_jabatan_del_st', 1)->where('jenis_jabatan_penugasan', 0)->get();
        return DataTables::of($jabatan)
            ->addColumn('actions', 'parameter/par_pegawai/jabatan.actions')
            ->rawColumns(['actions'])
            ->addIndexColumn()
            ->make(true);
    }
    public function tambah(Request $request)
    {

        return view('parameter/par_pegawai/jabatan.tambah');
    }
    public function save(Request $request)
    {
        DB::connection()->enableQueryLog();
        $savejbatan = [

            'jenis_jabatan_name' => $request->jabatan,
            'jenis_jabatan_sort' => $request->sort,
            'jenis_jabatan_penugasan' => 0,
            'jenis_jabatan_del_st' => 1
        ];

        $jabatan =Jabatan::create($savejbatan);
        $keterangan = 'menambahkan jabatan dengan ID '. $jabatan->jenis_jabatan_id. ', nama '.$request->jabatan;

        $cek = \Log::channel('database')->info($jabatan);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('tambah jabatan',$keterangan ,json_encode($query ));
        // $this->save_log('tambah jabatan',$keterangan ,$jabatan );
        
        Alert::success('Success', 'Data berhasil di Simpan');
        return redirect('parameter/pegawaispi/jabatan');
    }
    
    public function edit(Request $request, $id)
    {
        $jabatan = Jabatan::where('jenis_jabatan_del_st', 1)->where('jenis_jabatan_id', $id)->first();
        return view('parameter/par_pegawai/jabatan.edit', compact('jabatan'));
    }
    public function update(Request $request, $id)
    {
        DB::connection()->enableQueryLog();
        $update = [
            'jenis_jabatan_name' => $request->jabatan,
            'jenis_jabatan_sort' => $request->sort,
            // 'jenis_jabatan_penugasan' => $request->posisi,
        ];
        // dd($req);
        $jabata_ket =Jabatan::where('jenis_jabatan_id', $id)->first();
        $keterangan = 'Update jabatan dengan ID '. $id. ', dari '.$jabata_ket->jenis_jabatan_name. ' menjadi '.$request->jabatan;
        $jabatan =Jabatan::where('jenis_jabatan_id', $id)->update($update);

        $cek = \Log::channel('database')->info($jabatan);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('Update jabatan',$keterangan ,json_encode($query ));
        // $this->save_log('Update jabatan',$keterangan ,$jabatan );

        Alert::success('Success', 'Data berhasil di Simpan');
        return redirect('parameter/pegawaispi/jabatan');
    }

    public function detail(Request $request, $id)
    {
        $jabatan = Jabatan::where('jenis_jabatan_del_st', 1)->where('jenis_jabatan_id', $id)->first();
        return view('parameter/par_pegawai/jabatan.detail', compact('jabatan'));
    }
    public function confrimDel($id)
    {
        // dd($id);
        $deljbtn = Jabatan::where('jenis_jabatan_del_st', 1)->where('jenis_jabatan_id', $id)->first();
        return view('parameter/par_pegawai/jabatan.delete', compact('deljbtn'));
    }

    public function delete($id)
    {
        DB::connection()->enableQueryLog();
        $delete = [
            'jenis_jabatan_del_st' => 0
        ];
        $jabatan = Jabatan::where('jenis_jabatan_id', $id)->update($delete);
        $keterangan = 'Delete jabatan dengan ID '. $id;

        $cek = \Log::channel('database')->info($jabatan);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('delete jabatan',$keterangan ,json_encode($query ));
        // $this->save_log('delete jabatan', $keterangan, $jabatan );
        Alert::success('Success', 'Data berhasil di Delete');
        return redirect('parameter/pegawaispi/jabatan');
    }

    public function penugasan()
    {
        return view('parameter/par_pegawai/penugasan.index');
    }

    public function getPenugasan()
    {
        $jabatan = Jabatan::where('jenis_jabatan_del_st', 1)->where('jenis_jabatan_penugasan', 1)->get();
        return DataTables::of($jabatan)
            ->addColumn('actions', 'parameter/par_pegawai/penugasan.actions')
            ->rawColumns(['actions'])
            ->addIndexColumn()
            ->make(true);
    }
    public function tambahPenugasan(Request $request)
    {
        return view('parameter/par_pegawai/penugasan.tambah');
    }

    public function savePenugasan(Request $request)
    {
        DB::connection()->enableQueryLog();
        $savejbatan = [

            'jenis_jabatan_name' => $request->Penugasan,
            'jenis_jabatan_sort' => $request->sort,
            'jenis_jabatan_kode' => $request->kode_penugasan,
            'jenis_jabatan_penugasan' => 1,
            'jenis_jabatan_del_st' => 1
        ];

        $jabatan =Jabatan::create($savejbatan);
        $keterangan = 'menambahkan penugasan dengan ID '. $jabatan->jenis_jabatan_id. ', nama '.$request->Penugasan;

        $cek = \Log::channel('database')->info($jabatan);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('tambah penugasan',$keterangan ,json_encode($query ));
        // $this->save_log('tambah jabatan',$keterangan ,$jabatan );
        
        Alert::success('Success', 'Data berhasil di Simpan');
        return redirect('parameter/pegawaispi/penugasan');
    }


    public function editPenugasan(Request $request, $id)
    {
        $jabatan = Jabatan::where('jenis_jabatan_del_st', 1)->where('jenis_jabatan_penugasan', 1)->where('jenis_jabatan_id', $id)->first();
        return view('parameter/par_pegawai/penugasan.edit', compact('jabatan'));
    }
     public function updatePenugasan(Request $request, $id)
    {
        DB::connection()->enableQueryLog();
        $update = [
            'jenis_jabatan_name' => $request->Penugasan,
            'jenis_jabatan_sort' => $request->sort,
            'jenis_jabatan_kode' => $request->kode_penugasan,
            // 'jenis_jabatan_penugasan' => $request->posisi,
        ];
        // dd($req);
        $jabata_ket =Jabatan::where('jenis_jabatan_id', $id)->first();
        $keterangan = 'Update Penugasan dengan ID '. $id. ', dari '.$jabata_ket->jenis_jabatan_name. ' menjadi '.$request->jabatan;
        $jabatan =Jabatan::where('jenis_jabatan_id', $id)->update($update);

        $cek = \Log::channel('database')->info($jabatan);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('Update Penugasan',$keterangan ,json_encode($query ));
        // $this->save_log('Update jabatan',$keterangan ,$jabatan );

        Alert::success('Success', 'Data berhasil di Simpan');
        return redirect('parameter/pegawaispi/penugasan');
    }
    public function confrimPenugasan($id)
    {
        // dd($id);
        $deljbtn = Jabatan::where('jenis_jabatan_del_st', 1)->where('jenis_jabatan_id', $id)->first();
        return view('parameter/par_pegawai/penugasan.delete', compact('deljbtn'));
    }

    public function deletePenugasan($id)
    {
        DB::connection()->enableQueryLog();
        $delete = [
            'jenis_jabatan_del_st' => 0
        ];
        $jabatan = Jabatan::where('jenis_jabatan_id', $id)->delete();
        $keterangan = 'Delete penugasan dengan ID '. $id;

        $cek = \Log::channel('database')->info($jabatan);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('delete penugasan',$keterangan ,json_encode($query ));
        // $this->save_log('delete jabatan', $keterangan, $jabatan );
        Alert::success('Success', 'Data berhasil di Delete');
        return redirect('parameter/pegawaispi/penugasan');
    }

}
