<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('position', ['Part-Time', 'Part-Time-FullTime', 'Permanent-Temporary', 'Permanent-FullTime', 'Dean', 'Program-Head'])->nullable()->change();
        });
        Schema::table('clearances', function (Blueprint $table) {
            $table->enum('type', ['Part-Time', 'Part-Time-FullTime', 'Permanent-Temporary', 'Permanent-FullTime', 'Dean', 'Program-Head'])->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table){
            $table->enum('position', ['Permanent-FullTime', 'Permanent-PartTime', 'Temporary', 'Part-Timer'])->nullable()->change();
        });
        Schema::table('clearances', function (Blueprint $table) {
            $table->enum('type', ['Permanent', 'Part-Timer', 'Temporary'])->nullable()->change();
        });
    }
};
