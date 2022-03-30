<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditorPelatihanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auditor_pelatihan', function (Blueprint $table) {
            $table->increments('pelatihan_id');
            $table->integer('pelatihan_auditor_id')->nullable();
            $table->integer('pelatihan_kompetensi_id')->nullable();
            $table->string('pelatihan_nama', 225)->nullable();
            $table->string('pelatihan_durasi', 225)->nullable();
            $table->date('pelatihan_tanggal_awal')->nullable();
            $table->date('pelatihan_tanggal_akhir')->nullable();
            $table->string('pelatihan_penyelenggara', 225)->nullable();
            $table->string('pelatihan_sertifikat', 225)->nullable();
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
        Schema::dropIfExists('auditor_pelatihan');
    }
}
