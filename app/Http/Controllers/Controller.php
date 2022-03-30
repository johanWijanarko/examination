<?php

namespace App\Http\Controllers;

use App\Models\LogActivityModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function save_log($subject, $data){
        LogActivityModel::create([
           'log_subject' => $subject,
        //    'log_keterangan' => $keterangan,
           'log_data' => $data
           
           ]);
        // DB::listen(function ($q) use ($subject, $keterangan, $data) {
        //     Log::info($q->sql, $q->bindings, $q->time);
        // });

       

    }

}
