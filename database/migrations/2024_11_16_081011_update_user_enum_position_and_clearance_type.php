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
            $table->enum('position', ['Permanent-FullTime', 'Permanent-PartTime', 'Temporary', 'Part-Timer', 'Dean', 'Program-Head'])->nullable()->change();
        });
        Schema::table('clearances', function (Blueprint $table) {
            $table->enum('type', ['Permanent', 'Part-Timer', 'Temporary', 'Dean', 'Program-Head'])->nullable()->change();
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
