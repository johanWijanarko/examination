<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ModelHasRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::disk('local')->get('dbseeder/model_has_roles.json');
        $json = json_decode($json, true);
        
        foreach ($json as $key => $j) {

            DB::table('model_has_roles')->insert([
                'role_id' =>$j['role_id'],
                'model_type' =>$j['model_type'],
                'model_id' =>$j['model_id']
            ]);
           
        }
    }
}
