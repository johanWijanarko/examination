<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParLokasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('par_lokasi', function (Blueprint $table) {
            $table->increments('lokasi_id');
            $table->string('lokasi_name', 225)->nullable();
            $table->unsignedInteger('lokasi_provinsi_id')->nullable();
            $table->unsignedInteger('lokasi_pkabupaten_id')->nullable();
            $table->timestamps();

            $table->foreign('lokasi_provinsi_id')->references('id')->on('par_provinsi');
            $table->foreign('lokasi_pkabupaten_id')->references('id')->on('par_kabupaten');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('par_lokasi');
    }
}
