<?php

namespace App\Http\Controllers;

use App\Models\Direktorat;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class ParamDirektorat extends Controller
{
    public function index()
    {
        return view(('parameter/par_auditee/direktorat.index'));
    }
    public function getdirektorat()
    {
        $direktorat = Direktorat::where('direktorat_del_st', 1)->get();
        return DataTables::of($direktorat)
            ->addColumn('actions', 'parameter/par_auditee/direktorat.actions')
            ->rawColumns(['actions'])
            ->addIndexColumn()
            ->make(true);
    }
    public function tambah(Request $request)
    {
        return view('parameter/par_auditee/direktorat.tambah');
    }
    public function save(Request $request)
    {
        DB::connection()->enableQueryLog();
        $savejbatan = [
            'direktorat_name' => $request->direktorat,
            'direktorat_del_st' => 1
        ];

        $Direktorat = Direktorat::create($savejbatan);
        $keterangan = 'menambahkan  Direktorat Auditee dengan ID '. $Direktorat->direktorat_id. ', dengan nama  Direktorat Auditee '.$request->direktorat;
        
        $cek = \Log::channel('database')->info($Direktorat);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('tambah  Direktorat Auditee',$keterangan ,json_encode($query ));
        // $this->save_log('tambah  Direktorat Auditee',$keterangan ,$Direktorat );

        Alert::success('Success', 'Data berhasil di Simpan');
        return redirect('parameter/auditee/direktorat');
    }

    public function edit(Request $request, $id)
    {
        $direktorat = Direktorat::where('direktorat_del_st', 1)->where('direktorat_id', $id)->first();
        return view('parameter/par_auditee/direktorat.edit', compact('direktorat'));
    }
    public function update(Request $request, $id)
    {
        DB::connection()->enableQueryLog();
        $update = [
            'direktorat_name' => $request->direktorat
        ];
        $ketdir = Direktorat::where('direktorat_id', $id)->first();
        $Direktorat = Direktorat::where('direktorat_id', $id)->update($update);
        $keterangan = 'Update Direktorat Auditee dengan ID '. $id. ', dari Direktorat Auditee '.$ketdir->direktorat_name.' menjadi '.$request->direktorat;
        
        $cek = \Log::channel('database')->info($Direktorat);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('Update  Direktorat Auditee',$keterangan ,json_encode($query ));
        // $this->save_log('Update Direktorat Auditee',$keterangan ,$Direktorat );

        Alert::success('Success', 'Data berhasil di Simpan');
        return redirect('parameter/auditee/direktorat');
    }

    public function confrimDel($id)
    {
        $direktorat = Direktorat::where('direktorat_del_st', 1)->where('direktorat_id', $id)->first();
        return view('parameter/par_auditee/direktorat.delete', compact('direktorat'));
    }
    public function delete($id)
    {
        DB::connection()->enableQueryLog();
        $delete = [
            'direktorat_del_st' => 0
        ];
        $Direktorat = Direktorat::where('direktorat_id', $id)->update($delete);
        $keterangan = 'Delete Direktorat Auditee dengan ID '. $id;
        
        $cek = \Log::channel('database')->info($Direktorat);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('delete  Direktorat Auditee',$keterangan ,json_encode($query ));
        // $this->save_log('delete Direktorat Auditee', $keterangan, $Direktorat);

        Alert::success('Success', 'Data berhasil di Delete');
        return redirect('parameter/auditee/direktorat');
    }
}
