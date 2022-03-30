<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;

class PermisionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::disk('local')->get('dbseeder/permissions.json');
        $json = json_decode($json, true);
        
        foreach ($json as $key => $j) {
            DB::table('permissions')->insert([
                'id' =>$j['id'],
                'name' =>$j['name'],
                'guard_name' =>$j['guard_name'],
            ]);
           
        }
    }
}
