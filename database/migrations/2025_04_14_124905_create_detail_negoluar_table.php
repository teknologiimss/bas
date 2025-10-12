<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailNegoluarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_negoluar', function (Blueprint $table) {
            $table->id();
            $table->integer('id_del_negoluar');
            $table->integer('negoluar_id');
            $table->integer('id_pr');
            $table->integer('id_detail_pr');
            $table->integer('negoluar_qty');
            $table->string('harga');
            $table->string('harga_imss');
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
        Schema::dropIfExists('detail_negoluar');
    }
}
