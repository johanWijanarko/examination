<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParamPegawai extends Controller
{
    public function index()
    {
        return view('parameter/par_pegawai.index');
    }
}
