<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailSpphrfqTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_spphrfq', function (Blueprint $table) {
            $table->id();
            $table->integer('id_del_spphrfq');
            $table->integer('spphrfq_id');
            $table->integer('id_detail_pr');
            $table->integer('spphrfq_qty');
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
        Schema::dropIfExists('detail_spphrfq');
    }
}
