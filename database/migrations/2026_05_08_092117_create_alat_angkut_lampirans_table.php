<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlatAngkutLampiransTable extends Migration
{
    public function up()
    {
        Schema::create('alat_angkut_lampirans', function (Blueprint $table) {

            $table->id();

            $table->foreignId('checksheet_id')
                ->constrained('alat_angkut_checksheets')
                ->onDelete('cascade');

            $table->string('file');
            $table->string('nama_file')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('alat_angkut_lampirans');
    }
}