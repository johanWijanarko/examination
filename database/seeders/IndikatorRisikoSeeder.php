<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class IndikatorRisikoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::disk('local')->get('dbseeder/par_indikator_risiko.json');
        $json = json_decode($json, true);
        
        foreach ($json as $key => $j) {

            DB::table('par_indikator_risiko')->insert([
                'indikator_risiko_id' =>$j['indikator_risiko_id'],
                'indikator_risiko_faktor_risiko_id' =>$j['indikator_risiko_faktor_risiko_id'],
                'indikator_risiko_keterangan' =>$j['indikator_risiko_keterangan'],
                'indikator_risiko_level' =>$j['indikator_risiko_level'],
                'indikator_risiko_level_keterangan' =>$j['indikator_risiko_level_keterangan'],
                'indikator_risiko_del_st' =>$j['indikator_risiko_del_st']
            ]);
           
        }
    }
}
