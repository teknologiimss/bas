<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('email', 255)->nullable()->unique();
            $table->string('username', 25)->unique();
            $table->integer('role')->default(1)->comment('0 = Admin; 1 = Logistik; 2 = Wilayah 1; 3 = Wilayah 2; 4 = Gudang; 5 = Engineering; 6 = Sdm; 7 = Admin_log; 8 = Admin_wil1; 9 = Admin_wil2; 10 = Ekspedisi; 11 = Qc; 12 = Pemasaran; 13 = Keuangan; 14 = MRO; 18 = ACgraha');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255);
            $table->rememberToken();
            $table->timestamps();

            $table->index('username');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
