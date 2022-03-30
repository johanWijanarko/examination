<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Divisi;
use App\Models\Jabatan;
use Illuminate\Support\Str;
use App\Models\ParPelatihan;
use Illuminate\Http\Request;
use App\Models\ParKompetensi;
use App\Models\ParPendidikan;
use App\Models\PegawaiModels;
use App\Models\ParBagianModels;
use App\Models\ParUnitSpiModel;
use App\Models\SubBagianModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        return view('pegawai.index');
    }
    public function getPegawai(Request $request)
    {
        $getAuditors = PegawaiModels::with(['pegawaiHasBagian', 'pegawaiHasSubBagian'])->whereNotNull('pegawai_name')->orderBy('pegawai_name', 'asc')->get();
        return DataTables::of($getAuditors)
            ->addColumn('actions', 'pegawai.actions')
            ->addColumn('bagian', function ($getAuditor) {
                if ($getAuditor->pegawaiHasBagian) {
                    return $getAuditor->pegawaiHasBagian->nama_bagian;
                }
                return '';
            })
            ->addColumn('subBagian', function ($getAuditor) {
                if ($getAuditor->pegawaiHasSubBagian) {
                    return $getAuditor->pegawaiHasSubBagian->sub_bagian_nama;
                }
                return '';
            })
            ->rawColumns(['actions', 'bagian', 'subBagian'])
            ->addIndexColumn()
            ->make(true);
    }

    public function cek_nip(Request $request) {
        
        $if_exists = PegawaiModels::where('pegawai_nip', $request->nip)->count();
        $status = false;

        if ($if_exists > 0) { // jika sudah ada, maka true
            $status = true;
        }

        echo json_encode(array('status' => $status));
    }
    public function tambah(Request $request)
    {
        $bagian = ParBagianModels::get();
        // $subBagian = SubBagianModels::get();
        return view('pegawai.tambah', compact('bagian'));
    }
    function generateUUID($length)
    {
        $random = '';
        for ($i = 0; $i < $length; $i++) {
            $random .= rand(0, 1) ? rand(0, 9) : chr(rand(ord('a'), ord('z')));
        }
        return $random;
    }

    public function save(Request $request)
    {

        // dd($request->all());
        DB::connection()->enableQueryLog();
        $request->validate([
            'nama' => 'required'
        ]);

        $tglLahir = date('Y-m-d', strtotime( $request->tanggal_lahir));
        // dd($tglLahir);
        $saveAuditor = [
            'pegawai_nip' => $request->nip,
            'pegawai_name' => $request->nama,
            'pegawai_bagian_id' => $request->bagian,
            'pegawai_sub_bagian_id' => $request->subBagian,
            'pegawai_alamat' => $request->alamat,
            'pegawai_telp' => $request->pegawai_telp,
            'pegawai_email' => $request->email_auditor,

        ];
        // dd($saveAuditor);
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            //Custom name pattern as per application preference
            $filename = time() . '.' . $request->file('file')->extension();

            //Or - Get the original name of the uploaded file
            $filename =$this->generateUUID(6). '.' . $request->file('file')->getClientOriginalName();

            //Store the file in desired directory and assign the path to the file field in validated data
            $validatedData = $request->file('file')->storeAs('public/upload', $filename);
            $saveAuditor['pegawai_foto'] = $filename;
        }
        // dd($saveAuditor);
        $parpegewai = PegawaiModels::create($saveAuditor);

        $keterangan = 'menambahkan pegawai dengan ID '. $parpegewai->auditor_id. ', nama '.$request->nama;

        $cek = \Log::channel('database')->info($parpegewai);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('tambah pegawai' ,json_encode($query ));

        Alert::success('Success', 'Data berhasil di Simpan');
        return redirect('m_inventaris/pegawai');
    }

    public function detail($id)
    {
        $detailAuditors = PegawaiModels::with(['pegawaiHasBagian', 'pegawaiHasSubBagian'])->orderBy('pegawai_name', 'asc')->where('pegawai_id', $id)->first();
        
        return view('pegawai.detail', compact('detailAuditors'));
    }

    public function edit($id)
    {
        $bagian = ParBagianModels::get();
        $detailAuditors = PegawaiModels::with(['pegawaiHasBagian', 'pegawaiHasSubBagian'])->orderBy('pegawai_name', 'asc')->where('pegawai_id', $id)->first();
        $subBagian = SubBagianModels::where('sub_bagian_bagian_id',$detailAuditors->pegawai_bagian_id)->get();
        // dd($detailAuditors);
        return view('pegawai.edit', compact('detailAuditors', 'bagian', 'subBagian'));
    }

    public function update(Request $request, $id)
    {
        DB::connection()->enableQueryLog();
        $saveAuditor = [
            'pegawai_name' => $request->nama,
            'pegawai_bagian_id' => $request->bagian,
            'pegawai_sub_bagian_id' => $request->subBagian,
            'pegawai_alamat' => $request->alamat,
            'pegawai_telp' => $request->pegawai_telp,
            'pegawai_email' => $request->email_auditor
        ];
        // dd($saveAuditor);
        $getOld = ($request->old)? $request->old : [];
        // TindakLanjutEksternal::where('tl_eks_id', $id)->update($save);
        $checkFile = PegawaiModels::where('pegawai_id', $id)->pluck('pegawai_id');
        foreach ($checkFile as $key => $file) {
            if(!in_array($file, $getOld)){
                $getDelete =PegawaiModels::where('pegawai_id',$file)->first();
                Storage::delete('public/upload/'.$getDelete->pegawai_foto);
                
            }
        }  

         if ($request->hasFile('file') && $request->file('file')->isValid()) {
            //Custom name pattern as per application preference
            $filename = time() . '.' . $request->file('file')->extension();

            //Or - Get the original name of the uploaded file
            $filename =$this->generateUUID(6). '.' . $request->file('file')->getClientOriginalName();

            //Store the file in desired directory and assign the path to the file field in validated data
            $validatedData = $request->file('file')->storeAs('public/upload', $filename);
            $saveAuditor['pegawai_foto'] = $filename;
        }
        // dd($checkFile);
        $ketPegawai = PegawaiModels::where('pegawai_id', $id)->first();
        $parpegewai = PegawaiModels::where('pegawai_id', $id)->update($saveAuditor);

        $keterangan = 'Update pegawai dengan ID '. $id. ', dari '.$ketPegawai->pegawai_name. ' menjadi '.$request->nama;

        $cek = \Log::channel('database')->info($parpegewai);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('Update pegawai' ,json_encode($query ));

        Alert::success('Success', 'Data berhasil di Update');
        return redirect('m_inventaris/pegawai');
    }
    public function confrim($id)
    {
        $detailAuditors = PegawaiModels::orderBy('pegawai_name', 'asc')->where('pegawai_id', $id)->first();
        return view('pegawai.delete', compact('detailAuditors'));
    }

    public function delete($id)
    {
        DB::connection()->enableQueryLog();
       
        $parpegewai = PegawaiModels::where('pegawai_id', $id)->delete();

        $keterangan = 'Delete pegawai dengan ID '. $id;

        $cek = \Log::channel('database')->info($parpegewai);
        $query = DB::getQueryLog();
        $query = end($query);
        $this->save_log('UpdaDeletete pegawai' ,json_encode($query ));
        
        Alert::success('Success', 'Data berhasil di Delete');
        return redirect('pegawai/daftarpegawai');
    }
}
