<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::disk('local')->get('dbseeder/roles.json');
        $json = json_decode($json, true);
        
        foreach ($json as $key => $j) {

            Role::create([
                'id' =>$j['id'],
                'name' =>$j['name'],
                'guard_name' =>$j['guard_name']
                
            ]);
        }
    }
}
