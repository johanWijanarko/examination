<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Alert;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;


class MasterPegawaiController extends Controller
{
    //
    function __construct()
    {
         $this->middleware('permission:mstr_pegawai-list|mstr_pegawai-create|mstr_pegawai-edit|mstr_pegawai-delete|mstr_pegawai-detail', ['only' => ['index','save_pegawai']]);
         $this->middleware('permission:mstr_pegawai-create', ['only' => ['tambah_pegawai','save_pegawai']]);
         $this->middleware('permission:mstr_pegawai-edit', ['only' => ['editPegawai','updatePegawai']]);
         $this->middleware('permission:mstr_pegawai-delete', ['only' => ['deletePegawai']]);
         $this->middleware('permission:mstr_pegawai-detail', ['only' => ['detailPegawai']]);
    }
    
    public function index(Request $request){


        return view('pegawai.v_pegawai');
    }

    public function get_dataPegawai(){

        $pegawai = DB::table('auditor')
        ->leftJoin('par_pangkat_auditor', 'auditor_id_pangkat', '=','pangkat_id')
        ->leftJoin('par_jenis_jabatan', 'auditor_id_jabatan', '=','jenis_jabatan_id')
        ->leftJoin('auditee', 'auditee_kode', '=','auditor_id_divisi')
        ->select('auditor_id', 'auditor_nip', 'auditor_name', 'auditor_golongan', 'par_jenis_jabatan.jenis_jabatan_sub',  'auditor_departemen','auditee_name',DB::raw("CONCAT(jenis_jabatan,'-', jenis_jabatan_sub) as jabatan"))
        ->where('auditor_del_st', 1)
        ->where('auditor_status', 0 )
        ->orderBy('pangkat_name', 'desc');
        return DataTables::of($pegawai)
        ->addColumn('actions', 'pegawai.actions')
        ->rawColumns(['actions'])
        ->make(true);
    }

    public function detailPegawai($id){
        
        $pegawai = DB::table('auditor')
        ->leftJoin('par_pangkat_auditor', 'auditor_id_pangkat', '=','pangkat_id')
        ->leftJoin('par_jenis_jabatan', 'auditor_id_jabatan', '=','jenis_jabatan_id')
        ->select('auditor_tempat_lahir','auditor_nip', 'auditor_name', 'auditor_golongan', 'auditor_mobile', 'auditor_telp', 'auditor_email',DB::raw("CONCAT(pangkat_name,'-', pangkat_desc) as auditor_pangkat"),  'jenis_jabatan', 'jenis_jabatan_sub', 'auditor_alamat', 'auditor_jenis_kelamin', 'auditor_agama', 'auditor_foto', 'auditor_departemen', 'auditor_foto', 'auditor_tgl_lahir')
        ->where('auditor_del_st', '1')
        ->where('auditor_id', $id)
        ->first();
        // dd($pegawai);
        return view('pegawai.detail_pegawai', \compact('pegawai'));
    }

    public function editPegawai($id){
        $pegawai= DB::table('auditor')
        ->select('auditor_nip','auditor_id','auditor_agama','auditor_nip','auditor_name','auditor_tempat_lahir','auditor_tgl_lahir', 'auditor_alamat', 'auditor_jenis_kelamin','auditor_id_pangkat', 'auditor_id_jabatan', 'auditor_mobile', 'auditor_telp', 'auditor_email', 'auditor_foto','auditor_id_divisi')
        ->where('auditor_id', '=', $id)
        ->get();
        // dd($pegawai);

        $pangkat = DB::table('par_pangkat_auditor')
        ->select('pangkat_id', DB::raw("CONCAT(pangkat_name,'-', pangkat_desc) as auditor_pangkat"))
        ->where('pangkat_del_st', 1)
        ->orderBy('pangkat_name', 'asc')
        ->get();

        $unit_kerja = DB::table('auditee')
        ->select('auditee_id','auditee_kode', 'auditee_name')
        ->where('auditee_del_st', 1)
        ->orderBy('auditee_name', 'asc')
        ->get();

        $jabatan = DB::table('par_jenis_jabatan')
        ->select('jenis_jabatan_id',  DB::raw("CONCAT(jenis_jabatan,'-', jenis_jabatan_sub) as auditor_jabatan"))
        ->where('jenis_jabatan_del_st', 1)
        ->orderBy('jenis_jabatan_sort', 'asc')
        ->get();
        return view('pegawai.edit_pegawai', \compact('pegawai','pangkat', 'jabatan','unit_kerja'));
    }

    public function updatePegawai(Request $request, $id){
        // dd($id);
        $path = $request->file('foto');
        $update_file = [
            'auditor_nip' =>$request->nip,
            'auditor_name' =>$request->nama,
            // 'auditor_tempat_lahir' =>$request->tempat_lahir,
            // 'auditor_tgl_lahir' =>$request->tanggal_lahir,
            'auditor_alamat' =>$request->alamat,
            'auditor_jenis_kelamin' =>$request->kelamin,
            'auditor_agama' =>$request->agama,
            'auditor_id_divisi' =>$request->pangkat,
            // 'auditor_tmt' =>$request->tmt,
            'auditor_id_jabatan' =>$request->jabatan,
            'auditor_mobile' =>$request->mobile,
            'auditor_telp' =>$request->telp,
            'auditor_email' =>$request->email

        ];
        if($path != null){
            $path = $path->store('public/upload/');
            $update_file['auditor_foto'] = $path;
        }
        // dd($id);

        $affected = DB::table('auditor')
        ->where('auditor_id', $id)
        ->update($update_file);
        Alert::success('Success','Data berhasil di Update');
        return redirect()->route('pegawai');
    }

    public function tambah_pegawai(){
        $pangkat = DB::table('par_pangkat_auditor')
        ->select('pangkat_id', DB::raw("CONCAT(pangkat_name,'-', pangkat_desc) as auditor_pangkat"))
        ->where('pangkat_del_st', 1)
        ->orderBy('pangkat_name', 'asc')
        ->get();
        // dd($pangkat);

        $unit_kerja = DB::table('auditee')
        ->select('auditee_id','auditee_kode', 'auditee_name')
        ->where('auditee_del_st', 1)
        ->orderBy('auditee_name', 'asc')
        ->get();

        $jabatan = DB::table('par_jenis_jabatan')
        ->select('jenis_jabatan_id',  DB::raw("CONCAT(jenis_jabatan,'-', jenis_jabatan_sub) as auditor_jabatan"))
        ->where('jenis_jabatan_del_st', 1)
        ->orderBy('jenis_jabatan_sort', 'asc')
        ->get();
        return view('pegawai.tambah_pegawai', \compact('pangkat','jabatan', 'unit_kerja'));
    }

    public function save_pegawai(Request $request){
        $uuid = \Str::uuid();
        $uuid = str_replace('-', '', $uuid);
        $uuid = strval($uuid);
    //    dd($uuid);
    $path = $request->file('foto');
    $update_file = [
        'auditor_id' =>$uuid,
        'auditor_nip' =>$request->nip,
        'auditor_name' =>$request->nama,
        // 'auditor_tempat_lahir' =>$request->tempat_lahir,
        // 'auditor_tgl_lahir' =>$request->tanggal_lahir,
        'auditor_alamat' =>$request->alamat,
        'auditor_jenis_kelamin' =>$request->kelamin,
        'auditor_agama' =>$request->agama,
        'auditor_id_divisi' =>$request->pangkat,
        // 'auditor_tmt' =>$request->tmt,
        'auditor_id_jabatan' =>$request->jabatan,
        'auditor_mobile' =>$request->mobile,
        'auditor_telp' =>$request->telp,
        'auditor_email' =>$request->email,
        'auditor_del_st' => 1,
        'auditor_status'=> 0 

    ];
    if($path != null){
        $path = $path->store('public/upload/');
        $update_file['auditor_foto'] = $path;
    }
    // dd($update_file);

    $affected = DB::table('auditor')
    ->insert($update_file);
    Alert::success('Success','Data berhasil di Simpan');
    return redirect()->route('pegawai');

    }

    public function deletePegawai($id){
        DB::table('auditor')->where('auditor_id', $id)
        ->update(['auditor_del_st'=> 0]);
        Alert::success('Success','Data berhasil di Dihapus');
        return redirect()->route('pegawai');
    }

}
