<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParUnitSpiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('par_unit_spi', function (Blueprint $table) {
            $table->increments('unit_spi_id');
            $table->string('unit_spi_nama', 225)->nullable();
            $table->integer('unit_spi_del_st')->nullable();
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
        Schema::dropIfExists('par_unit_spi');
    }
}
