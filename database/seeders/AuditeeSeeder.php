<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AuditeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = Storage::disk('local')->get('dbseeder/auditee.json');
        $json = json_decode($json, true);
        // print_r($json);
        foreach ($json as $key => $j) {

            DB::table('auditee')->insert([
                'auditee_id' =>$j['auditee_id'],
                'auditee_kode' =>$j['auditee_kode'],
                'auditee_name' =>$j['auditee_name'],
                'auditee_parrent_id' =>$j['auditee_parrent_id'],
                'auditee_direktorat_id' =>$j['auditee_direktorat_id'],
                'auditee_del_st' =>$j['auditee_del_st'],
                'auditee_kabupaten_id' =>$j['auditee_kabupaten_id'],
                'auditee_alamat' =>$j['auditee_alamat'],
                'auditee_telp' =>$j['auditee_telp'],
                'auditee_telp_pimpinan' =>$j['auditee_telp_pimpinan'],
                'auditee_telp_sekretaris' =>$j['auditee_telp_sekretaris'],
                'auditee_email' =>$j['auditee_email'],
            ]);
        }
    }
}
