<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RegenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::disk('local')->get('dbseeder/kabupaten.json');
        $json = json_decode($json, true);
        // print_r($json);
        foreach ($json as $key => $j) {

            DB::table('regencies')->insert([
                'id' =>$j['id'],
                'province_id' =>$j['province_id'],
                'name' =>$j['name']
                
            ]);
        }
    }
}
