<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class JabatanPenugasanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::disk('local')->get('dbseeder/par_jenis_jabatan.json');
        $json = json_decode($json, true);
        foreach ($json as $key => $j) {

            DB::table('par_jenis_jabatan')->insert([
                'jenis_jabatan_id' =>$j['jenis_jabatan_id'],
                'jenis_jabatan_penugasan' =>$j['jenis_jabatan_penugasan'],
                'jenis_jabatan_name' =>$j['jenis_jabatan_name'],
                'jenis_jabatan_kode' =>$j['jenis_jabatan_kode'],
                'jenis_jabatan_sort' =>$j['jenis_jabatan_sort'],
                'jenis_jabatan_del_st' =>$j['jenis_jabatan_del_st']
            ]);
           
        }
    }
}
