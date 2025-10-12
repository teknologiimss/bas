<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailLoiluarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_loiluar', function (Blueprint $table) {
            $table->id();
            $table->integer('id_del_loiluar');
            $table->integer('loiluar_id');
            $table->integer('id_pr');
            $table->integer('id_detail_pr');
            $table->integer('loiluar_qty');
            $table->string('harga');
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
        Schema::dropIfExists('detail_loiluar');
    }
}
