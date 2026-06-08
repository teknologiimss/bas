<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRewindingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rewinding_details', function (Blueprint $table) {
            $table->id();

            $table
                ->foreignId('rewinding_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->date('tanggal')->nullable();

            $table->enum('status', [
                'Open',
                'Closed'
            ])->default('Open');

            $table->text('keterangan')->nullable();

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
        Schema::dropIfExists('rewinding_details');
    }
}
