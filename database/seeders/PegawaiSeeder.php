<?php

namespace Database\Seeders;

use App\Models\PegawaiModels;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::disk('local')->get('dbseeder/auditor.json');
        $json = json_decode($json, true);

        foreach ($json as $key => $j) {

            PegawaiModels::create([
                'auditor_id' =>$j['auditor_id'],
                'auditor_nip' =>$j['auditor_nip'],
                'auditor_name' =>$j['auditor_name'],
                'auditor_alamat' => $j['auditor_alamat'],
                'auditor_agama' =>$j['auditor_agama'],
                'auditor_jenis_kelamin' =>$j['auditor_jenis_kelamin'],
                'auditor_id_jabatan' =>$j['auditor_id_jabatan'],
                'auditor_unit_spi' =>$j['auditor_unit_spi'],
                'auditor_tempat_lahir' => $j['auditor_tempat_lahir'],
                'auditor_tgl_lahir' =>$j['auditor_tgl_lahir'],
                'auditor_mobile' =>$j['auditor_mobile'],
                'auditor_telp' =>$j['auditor_telp'],
                'auditor_email' => $j['auditor_email'],
                'auditor_inisial' => $j['auditor_inisial'],
                'auditor_del_st' => $j['auditor_del_st']
            ]);
        }
    }
}
