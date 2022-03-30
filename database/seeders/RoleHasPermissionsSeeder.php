<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoleHasPermissions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RoleHasPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::disk('local')->get('dbseeder/role_has_permissions.json');
        $json = json_decode($json, true);
        
        foreach ($json as $key => $j) {

            DB::table('role_has_permissions')->insert([
                'permission_id' =>$j['permission_id'],
                'role_id' =>$j['role_id']
            ]);
           
        }
    }
}
