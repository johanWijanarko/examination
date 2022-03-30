<?php

namespace App\Http\Controllers;

use App\Models\ParPelatihan;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class Pelatihan extends Controller
{
    public function save(Request $request)
    {
        $id = $request->auidtor_id;
        // $path = $request->file('file');
        $saveAuditor = [
            'pelatihan_auditor_id' => $request->auidtor_id,
            'pelatihan_kompetensi_id' => $request->pelatihan_id,
            'pelatihan_nama' => $request->nama_pelatihan,
            'pelatihan_durasi' => $request->jam,
            'pelatihan_tanggal_awal' => $request->mulai,
            'pelatihan_tanggal_akhir' => $request->akhir,
            'pelatihan_penyelenggara' => $request->penyelenggara,
            // 'pelatihan_sertifikat' => $path

        ];
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            //Custom name pattern as per application preference
            $filename = time() . '.' . $request->file('file')->extension();

            //Or - Get the original name of the uploaded file
            $filename = $request->file('file')->getClientOriginalName();

            //Store the file in desired directory and assign the path to the file field in validated data
            $validatedData = $request->file('file')->storeAs('public/upload', $filename);
            $save['pelatihan_sertifikat'] = $validatedData;
        }

        ParPelatihan::create($saveAuditor);
        Alert::success('Success', 'Data berhasil di Simpan');
        return redirect('pegawai/daftarpegawai/detailpegawai/' . $id);
    }

    public function detail(Request $request)
    {
        // dd($id);
        $pelatihandetail = ParPelatihan::with('jenisPelatihan')->where('pelatihan_id', $request->get('id'))->first();

        return response()->json($pelatihandetail);
    }
    public function update(Request $request)
    {
        // dd($request->all());
        $id = $request->pelatihan_id;
        $update = [
            'pelatihan_kompetensi_id' => $request->pelatihan_id_edit,
            'pelatihan_nama' => $request->pelatihan_edit,
            'pelatihan_durasi' => $request->jam_edit,
            'pelatihan_tanggal_awal' => $request->mulai_edit,
            'pelatihan_tanggal_akhir' => $request->akhir_edit,
            'pelatihan_penyelenggara' => $request->penyelenggara_edit,

        ];
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            //Custom name pattern as per application preference
            $filename = time() . '.' . $request->file('file')->extension();

            //Or - Get the original name of the uploaded file
            $filename = $request->file('file')->getClientOriginalName();

            //Store the file in desired directory and assign the path to the file field in validated data
            $validatedData = $request->file('file')->storeAs('public/upload', $filename);
            $update['pelatihan_sertifikat'] = $validatedData;
        }
        // dd($update);
        $updatePel = ParPelatihan::where('pelatihan_id', $id)->update($update);
        Alert::success('Success', 'Data berhasil di Simpan');
        return response()->json($updatePel);
    }
    public function confrim($id)
    {
        $pelatihandetail = ParPelatihan::where('pelatihan_id', $id)->first();
        // dd($pelatihandetail);
        return view('pegawai/pelatihan.delete', compact('pelatihandetail'));
    }

    public function delete(Request $request, $id, $id_pgwai)
    {
        // dd($id_pgwai);
        ParPelatihan::where('pelatihan_id', $id)->delete();
        Alert::success('Success', 'Data berhasil di Delete');
        return redirect('pegawai/daftarpegawai/detailpegawai/' . $id_pgwai);
    }
}
