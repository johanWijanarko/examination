<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FaktorRisikoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::disk('local')->get('dbseeder/par_faktor_risiko.json');
        $json = json_decode($json, true);
        
        foreach ($json as $key => $j) {

            DB::table('par_faktor_risiko')->insert([
                'faktor_risiko_id' =>$j['faktor_risiko_id'],
                'faktor_risiko_judul' =>$j['faktor_risiko_judul'],
                'faktor_risiko_keterangan' =>$j['faktor_risiko_keterangan'],
                'faktor_risiko_del_st' =>$j['faktor_risiko_del_st']
            ]);
           
        }
    }
}
