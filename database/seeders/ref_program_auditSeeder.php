<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ref_program_auditSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::disk('local')->get('dbseeder/ref_program_audit.json');
        $json = json_decode($json, true);
        // print_r($json);
        foreach ($json as $key => $j) {

            DB::table('ref_program_audit')->insert([
                'ref_program_id' =>$j['ref_program_id'],
                'ref_program_id_type' =>$j['ref_program_id_type'],
                'ref_program_code' =>$j['ref_program_code'],
                'ref_program_aspek_id' =>$j['ref_program_aspek_id'],
                'ref_program_title' =>$j['ref_program_title'],
                'ref_program_procedure' =>$j['ref_program_procedure'],
                'ref_program_dokumen' =>$j['ref_program_dokumen'],
                'ref_program_del_st' =>$j['ref_program_del_st']
                
            ]);
        }
    }
}
