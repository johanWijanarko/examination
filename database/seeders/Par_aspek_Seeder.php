<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Par_aspek_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::disk('local')->get('dbseeder/par_aspek.json');
        $json = json_decode($json, true);
        // print_r($json);
        foreach ($json as $key => $j) {

            DB::table('par_aspek')->insert([
                'aspek_id' =>$j['aspek_id'],
                'aspek_kode' =>$j['aspek_kode'],
                'aspek_name' =>$j['aspek_name'],
                'aspek_del_st' =>$j['aspek_del_st']
                
            ]);
        }
    }
}
