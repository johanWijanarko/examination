<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParDirektoratTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('par_direktorat', function (Blueprint $table) {
            $table->increments('direktorat_id');
            $table->string('direktorat_name', 225)->nullable();
            $table->integer('direktorat_del_st')->nullable();
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
        Schema::dropIfExists('par_direktorat');
    }
}
