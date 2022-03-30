<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class par_bagian extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('par_bagian')->insert([
            'kode_bagian' => Str::random(4),
            'nama_bagian' => Str::random(10),
        ]);
    }
}
