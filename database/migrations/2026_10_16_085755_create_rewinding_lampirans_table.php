<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRewindingLampiransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rewinding_lampirans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rewinding_id')->constrained('rewindings')->onDelete('cascade');
            $table->string('tipe');  // 'keluar' atau 'masuk'
            $table->string('file');
            $table->string('nama_file');
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
        Schema::dropIfExists('rewinding_lampirans');
    }
}
