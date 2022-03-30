<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParKabupatenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('par_kabupaten', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('province_id');
            $table->string('name', 225)->nullable();
            $table->timestamps();

             $table->foreign('province_id')->references('id')->on('par_provinsi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('par_kabupaten');
    }
}
