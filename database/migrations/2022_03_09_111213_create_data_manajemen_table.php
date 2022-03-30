<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataManajemenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_manajemen', function (Blueprint $table) {
            $table->increments('data_manajemen_id');
            $table->integer('data_manajemen_kode_id')->nullable();
            $table->string('data_manajemen_name', 225)->nullable();
            $table->integer('data_manajemen_merk_id')->nullable();
            $table->integer('data_manajemen_type_id')->nullable();
            $table->integer('data_manajemen_kondisi_id')->nullable();
            $table->integer('data_manajemen_gedung_id')->nullable();
            $table->integer('data_manajemen_ruangan_id')->nullable();
            $table->integer('data_manajemen_supplier_id')->nullable();
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
        Schema::dropIfExists('data_manajemen');
    }
}
