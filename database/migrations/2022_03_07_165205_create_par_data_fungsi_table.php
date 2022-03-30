<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParDataFungsiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('par_data_fungsi', function (Blueprint $table) {
            $table->increments('data_fungsi_id');
            $table->string('kode_data_fungsi', 225)->nullable();
            $table->string('nama_data_fungsi', 225)->nullable();
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
        Schema::dropIfExists('par_data_fungsi');
    }
}
