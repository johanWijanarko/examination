<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DirektoratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::disk('local')->get('dbseeder/par_direktorat.json');
        $json = json_decode($json, true);
        // print_r($json);
        foreach ($json as $key => $j) {

            DB::table('par_direktorat')->insert([
                'direktorat_id' =>$j['direktorat_id'],
                'direktorat_name' =>$j['direktorat_name'],
                'direktorat_del_st' =>$j['direktorat_del_st']
                
            ]);
        }
    }
}
