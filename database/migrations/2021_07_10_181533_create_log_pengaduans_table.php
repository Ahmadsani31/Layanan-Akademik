<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogPengaduansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_pengaduans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengaduan_id')->references('id')->on('pengaduans');
            $table->foreignId('mahasiswa_id')->references('id')->on('mahasiswas');
            $table->foreignId('petugas_id')->references('id')->on('users');
            $table->string('keterangan');
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
        Schema::dropIfExists('log_pengaduans');
    }
}
