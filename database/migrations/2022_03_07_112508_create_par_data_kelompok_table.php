<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParDataKelompokTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('par_data_kelompok', function (Blueprint $table) {
            $table->increments('data_kelompok_id');
            $table->string('kode_data_kelompok', 225)->nullable();
            $table->string('nama_data_kelompok', 225)->nullable();
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
        Schema::dropIfExists('par_data_kelompok');
    }
}
