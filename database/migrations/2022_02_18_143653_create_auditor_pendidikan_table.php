<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditorPendidikanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auditor_pendidikan', function (Blueprint $table) {
            $table->increments('pendidikan_id');
            $table->integer('pendidikan_auditor_id')->nullable();
            $table->string('pendidikan_tingkat', 225)->nullable();
            $table->string('pendidikan_institusi', 225)->nullable();
            $table->string('pendidikan_kota', 225)->nullable();
            $table->string('pendidikan_negara', 225)->nullable();
            $table->integer('pendidikan_tahun')->nullable();
            $table->string('pendidikan_jurusan', 225)->nullable();
            $table->string('pendidikan_nilai', 225)->nullable();
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
        Schema::dropIfExists('auditor_pendidikan');
    }
}
