<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_data', function (Blueprint $table) {
            $table->increments('trs_id');
            $table->string('trs_kode', 30);
            $table->integer('trs_data_id');
            $table->integer('trs_jenis_id');
            $table->string('trs_name', 225);
            $table->integer('trs_pegawai_id');
            $table->integer('trs_sub_bagian_id');
            $table->integer('trs_kelompok_id');
            $table->integer('trs_pic_id');
            $table->date('trs_date');
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
        Schema::dropIfExists('transaksi_data');
    }
}
