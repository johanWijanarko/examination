<?php

namespace Database\Seeders;

use App\Models\MenuModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::disk('local')->get('dbseeder/menu.json');
        $json = json_decode($json, true);
        
        foreach ($json as $key => $j) {

            MenuModel::create([
                'id' =>$j['id'],
                'nama_menu' =>$j['nama_menu'],
                'master_menu' =>$j['master_menu'],
                'level_menu' => $j['level_menu'],
                'url' =>$j['url'],
                'icon' =>$j['icon'],
                'permission' =>$j['permission'],
                'no_urut' =>$j['no_urut'],
                'status' => $j['status']
            ]);
        }
    }
}
