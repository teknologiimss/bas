<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRewindingDetailLampiransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rewinding_detail_lampirans', function (Blueprint $table) {
            $table->id();

            $table
                ->foreignId('rewinding_detail_id')
                ->constrained()
                ->cascadeOnDelete();

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
        Schema::dropIfExists('rewinding_detail_lampirans');
    }
}
