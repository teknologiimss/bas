<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToolMutationsTable extends Migration
{
    public function up()
    {
        Schema::create('tool_mutations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mro_tool_id')->constrained('mro_tools')->onDelete('cascade');
            $table->string('nama_peminjam');
            $table->integer('qty_pinjam');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->nullable();
            $table->enum('status', ['Dipinjam', 'Dikembalikan'])->default('Dipinjam');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tool_mutations');
    }
}
