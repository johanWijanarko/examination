<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AuditTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::disk('local')->get('dbseeder/par_audit_type.json');
        $json = json_decode($json, true);
        
        foreach ($json as $key => $j) {

            DB::table('par_audit_type')->insert([
                'audit_type_id' =>$j['audit_type_id'],
                'audit_type_name' =>$j['audit_type_name'],
                'audit_type_code' =>$j['audit_type_code'],
                'audit_type_desc' =>$j['audit_type_desc'],
                'audit_type_opsi' =>$j['audit_type_opsi'],
                'audit_type_del_st' =>$j['audit_type_del_st']
            ]);
           
        }
    }
}
