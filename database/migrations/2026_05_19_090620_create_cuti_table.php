<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cuti', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('user_id');

            $table->string('jenis')->nullable();

            $table->date('tanggal_mulai');

            $table->date('tanggal_selesai');

            $table->text('keterangan')->nullable();

            $table->integer('jumlah_hari')->default(0);

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cuti');
    }
};