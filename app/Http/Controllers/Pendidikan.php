<?php

namespace App\Http\Controllers;

use App\Models\ParPendidikan;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class Pendidikan extends Controller
{
    public function save(Request $request)
    {
        $id = $request->auidtor_id_;
        $pendidikan = [
            'pendidikan_auditor_id' => $id,
            'pendidikan_tingkat' => $request->pendidikan,
            'pendidikan_institusi' => $request->Institusi,
            'pendidikan_kota' => $request->Kota,
            'pendidikan_negara' => $request->Negara,
            'pendidikan_tahun' => $request->Tahun,
            'pendidikan_nilai' => $request->ipk,
            'pendidikan_jurusan' => $request->Jurusan,

        ];

        ParPendidikan::create($pendidikan);
        Alert::success('Success', 'Data berhasil di Simpan');
        return redirect('pegawai/daftarpegawai/detailpegawai/' . $id);
    }

    public function edit(Request $request)
    {
        $pendidikan = ParPendidikan::where('pendidikan_id', $request->get('id'))->first();

        return response()->json($pendidikan);
    }
    public function update(Request $request)
    {
        // dd($request->all());
        $id = $request->auditor_id_;

        $update = [
            'pendidikan_tingkat' => $request->pendidikan_edit,
            'pendidikan_institusi' => $request->Instiusi_edit,
            'pendidikan_kota' => $request->Kota_edit,
            'pendidikan_negara' => $request->Negara_edit,
            'pendidikan_tahun' => $request->Tahun_edit,
            'pendidikan_nilai' => $request->ipk_edit,
            'pendidikan_jurusan' => $request->Jurusan_edit,
        ];

        $updatePel = ParPendidikan::where('pendidikan_id', $request->pend_id)->update($update);
        Alert::success('Success', 'Data berhasil di Simpan');
        return redirect('pegawai/daftarpegawai/detailpegawai/' . $id);
    }
    public function confrim($id)
    {
        $pendidikan = ParPendidikan::where('pendidikan_id', $id)->first();
        // dd($pendidikan);
        return view('pegawai/pendidikan.delete', compact('pendidikan'));
    }

    public function delete($id, $id_pgwai)
    {
        ParPendidikan::where('pendidikan_id', $id)->delete();
        Alert::success('Success', 'Data berhasil di Delete');
        return redirect('pegawai/daftarpegawai/detailpegawai/' . $id_pgwai);
    }
}
