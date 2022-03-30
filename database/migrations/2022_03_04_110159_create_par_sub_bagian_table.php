<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParSubBagianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('par_sub_bagian', function (Blueprint $table) {
                $table->increments('sub_bagian_id');
                $table->unsignedInteger('sub_bagian_bagian_id')->nullable();
                $table->string('sub_bagian_kode', 225)->nullable();
                $table->string('sub_bagian_nama', 225)->nullable();
                $table->timestamps();

                $table->foreign('sub_bagian_bagian_id')->references('bagian_id')->on('par_bagian');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('par_sub_bagian');
    }
}
