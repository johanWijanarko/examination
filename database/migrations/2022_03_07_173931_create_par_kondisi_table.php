<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParKondisiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('par_kondisi', function (Blueprint $table) {
            $table->increments('data_kondisi_id');
            $table->string('kode_data_kondisi', 225)->nullable();
            $table->string('nama_data_kondisi', 225)->nullable();
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
        Schema::dropIfExists('par_kondisi');
    }
}
