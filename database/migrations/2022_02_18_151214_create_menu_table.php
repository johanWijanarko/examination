<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_menu', 225)->nullable();
            $table->integer('level_menu')->nullable();
            $table->integer('master_menu')->nullable();
            $table->string('url', 225)->nullable();
            $table->string('icon', 225)->nullable();
            $table->string('permission', 225)->nullable();
            $table->integer('no_urut')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('menu');
    }
}
