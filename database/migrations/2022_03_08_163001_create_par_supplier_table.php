<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParSupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('par_supplier', function (Blueprint $table) {
            $table->increments('supplier_id');
            $table->string('supplier_kode', 225)->nullable();
            $table->string('supplier_name', 225)->nullable();
            $table->string('supplier_alamat', 225)->nullable();
            $table->unsignedInteger('supplier_provinsi_id')->nullable();
            $table->unsignedInteger('supplier_kabupaten_id')->nullable();
            $table->timestamps();

            $table->foreign('supplier_provinsi_id')->references('id')->on('par_provinsi');
            $table->foreign('supplier_kabupaten_id')->references('id')->on('par_kabupaten');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('par_supplier');
    }
}
