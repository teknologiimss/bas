<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpphrfqTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spphrfq', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_spphrfq');
            $table->integer('lampiran');
            $table->integer('vendor_id');
            $table->date('tanggal_spphrfq');
            $table->string('batas_spphrfq');
            $table->string('perihal');
            $table->string('penerima');
            $table->string('alamat');
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
        Schema::dropIfExists('spphrfq');
    }
}
