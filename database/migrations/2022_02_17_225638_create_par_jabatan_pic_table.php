<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParJabatanPicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('par_jabatan_pic', function (Blueprint $table) {
            $table->increments('jabatan_pic_id');
            $table->string('jabatan_pic_name', 225)->nullable();
            $table->integer('jabatan_pic_short')->nullable();
            $table->integer('jabatan_pic_del_st')->nullable();
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
        Schema::dropIfExists('par_jabatan_pic');
    }
}
