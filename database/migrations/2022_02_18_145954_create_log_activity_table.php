<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_activity', function (Blueprint $table) {
            $table->increments('log_id');
            $table->string('log_subject', 225)->nullable();
            $table->string('log_url', 225)->nullable();
            $table->string('log_user', 225)->nullable();
            $table->string('log_keterangan', 225)->nullable();
            $table->text('log_data')->nullable();
            $table->string('log_ip', 225)->nullable();
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
        Schema::dropIfExists('log_activity');
    }
}
