<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMutasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mutasi', function (Blueprint $table) {
            $table->increments('mutasi_id');
            $table->string('mutasi_keterangan', 225);
            $table->integer('mutasi_trs_id');
            $table->integer('mutasi_objek_id');
            $table->integer('mutasi_pegawai_awal_id');
            $table->integer('mutasi_pegawai_kedua_id');
            $table->integer('mutasi_kondisi_awal_id');
            $table->integer('mutasi_kondisi_skrg_id');
            $table->date('mutasi_tgl');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mutasi');
    }
}
