<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArsipDokumenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arsip_dokumen', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pr_id');
            $table->string('nama_dokumen');
            $table->string('file_path');
            $table->timestamps();

            $table->foreign('pr_id')->references('id')->on('purchase_request')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('arsip_dokumen');
    }
}
