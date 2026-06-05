<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rewindings', function (Blueprint $table) {

            $table->id();

            $table->string('no_sjn');
            $table->date('tanggal_sjn');
            $table->date('tanggal_masuk_sjn');

            $table->string('status')->default('Open');

            $table->text('deskripsi')->nullable();

            $table->integer('qty')->default(1);

            $table->string('satuan')->nullable();

            $table->text('keterangan')->nullable();

            $table->string('lampiran')->nullable();

            $table->string('no_sppjp')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rewindings');
    }
};