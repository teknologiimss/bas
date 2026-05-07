<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixForeignChecksheetResults extends Migration
{
    public function up()
    {
        Schema::table('checksheet_results', function (Blueprint $table) {

            // hapus foreign lama
            $table->dropForeign(['item_id']);

        });

        Schema::table('checksheet_results', function (Blueprint $table) {

            // buat foreign baru
            $table->foreign('item_id')
                ->references('id')
                ->on('checksheet_items')
                ->onDelete('cascade');

        });
    }

    public function down()
    {
        Schema::table('checksheet_results', function (Blueprint $table) {

            $table->dropForeign(['item_id']);

            $table->foreign('item_id')
                ->references('id')
                ->on('items')
                ->onDelete('cascade');

        });
    }
}