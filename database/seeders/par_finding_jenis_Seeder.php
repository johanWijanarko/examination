<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class par_finding_jenis_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::disk('local')->get('dbseeder/par_finding_jenis.json');
        $json = json_decode($json, true);
        // print_r($json);
        foreach ($json as $key => $j) {

            DB::table('par_finding_jenis')->insert([
                'jenis_temuan_id' =>$j['jenis_temuan_id'],
                'jenis_temuan_id_sub_type' =>$j['jenis_temuan_id_sub_type'],
                'jenis_temuan_code' =>$j['jenis_temuan_code'],
                'jenis_temuan_name' =>$j['jenis_temuan_name'],
                'jenis_temuan_del_st' =>$j['jenis_temuan_del_st']
                
            ]);
        }
    }
}
