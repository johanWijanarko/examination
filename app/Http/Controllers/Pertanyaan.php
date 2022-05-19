<?php

namespace App\Http\Controllers;

use App\Models\JawabanModel;
use Illuminate\Http\Request;
use App\Models\PertanyaanModel;

class Pertanyaan extends Controller
{
    public function index(){
        $pertanyaan = PertanyaanModel::with(['PertanyanHasJawaban'])->get();

        // dd($pertanyaan);
        return view('pertanyaan.index', compact('pertanyaan'));
    }
    public function create(){

        return view('pertanyaan.create');
    }

    public function save(Request $request){

    //    dd($request->all());


        $question = PertanyaanModel::create([
            'pertanyaan'        => $request->input('detail'),
            'jawaban'        => $request->input('answer'),
            'bobot'   => $request->input('bobot'),
            // 'created_by'    => Auth()->id()
        ]);

        $jawaban = JawabanModel::create([
            'pertanyaan_id'  => $question->id,
            'jawaban_a'      => $request->input('option_A'),
            'jawaban_b'      => $request->input('option_B'),
            'jawaban_c'      => $request->input('option_C'),
            'jawaban_d'      => $request->input('option_D'),
            'jawaban_e'      => $request->input('option_E'),

        ]);

        return redirect('pertanyan/quest');
    }
}
