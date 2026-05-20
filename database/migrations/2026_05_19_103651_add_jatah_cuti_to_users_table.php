<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {

            $table->integer('jatah_cuti')
                ->default(8);

        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn('jatah_cuti');

        });
    }
};

