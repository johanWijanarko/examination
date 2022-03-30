<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParPangkatAuditorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('par_pangkat_auditor', function (Blueprint $table) {
            $table->increments('pangkat_id');
            $table->integer('pangkat_name')->nullable();
            $table->integer('pangkat_desc')->nullable();
            $table->integer('pangkat_del_st')->nullable();
            $table->integer('pangkat_sort')->nullable();
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
        Schema::dropIfExists('par_pangkat_auditor');
    }
}
