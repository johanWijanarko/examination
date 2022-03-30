<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogActivityModel;

class LogActivityController extends Controller
{
    public function index(Request $request){
         $cari = $request->cari;

        $logs = LogActivityModel::when($request->cari, function ($q) use ($request) {
                $q->where('log_subject', 'like', '%' . $request->cari . '%');
                // $q->orWhere('log_keterangan', 'like', '%' . $request->cari . '%');
                $q->orWhere('log_user', 'like', '%' . $request->cari . '%');
            })->orderBy('log_id', 'desc')
            ->paginate(10);
        $logs->appends(['_token' => $request->_token, 'cari=' => request()->$cari]);
        // dd($logs);
        return view('log.index', compact('logs'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
      
    }
}
