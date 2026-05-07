<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterChecksheetResultsAddDetailId extends Migration
{
    public function up()
    {
        Schema::table('checksheet_results', function (Blueprint $table) {

            // hapus foreign item_id lama
            $table->dropForeign(['item_id']);

            // nullable dulu
            $table->unsignedBigInteger('detail_id')->nullable()->after('item_id');

            $table->foreign('detail_id')
                ->references('id')
                ->on('checksheet_item_details')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('checksheet_results', function (Blueprint $table) {

            $table->dropForeign(['detail_id']);

            $table->dropColumn('detail_id');

            $table->foreign('item_id')
                ->references('id')
                ->on('checksheet_items')
                ->onDelete('cascade');
        });
    }
}