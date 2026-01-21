<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSppdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sppd', function (Blueprint $table) {
            $table->id();
            $table->string('kode_proyek');
            $table->string('tujuan');
            $table->string('keperluan');
            $table->string('lama_perjalanan');
            $table->date('terhitung_mulai');
            $table->date('terhitung_selesai');
            $table->integer('lampiran');
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
        Schema::dropIfExists('sppd');
    }
}
