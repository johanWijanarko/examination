<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ref_program_prosedurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::disk('local')->get('dbseeder/ref_program_prosedur.json');
        $json = json_decode($json, true);
        // print_r($json);
        foreach ($json as $key => $j) {

            DB::table('ref_program_prosedur')->insert([
                'prosedur_id' =>$j['prosedur_id'],
                'prosedur_program_id' =>$j['prosedur_program_id'],
                'prosedur_desc' =>$j['prosedur_desc'],
                'prosedur_sort' =>$j['prosedur_sort']
                
            ]);
        }
    }
}
