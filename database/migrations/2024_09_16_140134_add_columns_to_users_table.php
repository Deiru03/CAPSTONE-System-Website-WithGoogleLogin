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
            $table->enum('user_type', ['Admin', 'Faculty', 'Dean', 'Program-Head'])->after('email');
            $table->string('program')->nullable()->after('user_type');
            $table->enum('position', ['Permanent-FullTime', 'Permanent-PartTime', 'Temporary', 'Part-Timer'])->nullable()->after('program');
            $table->integer('units')->nullable()->after('position');
            $table->enum('clearances_status', ['pending', 'return', 'complete'])->default('pending')->after('units');
            $table->timestamp('last_clearance_update')->nullable()->after('clearances_status');
            $table->string('checked_by')->nullable()->after('last_clearance_update');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn([
                'user_type',
                'program',
                'position',
                'units',
                'clearances_status',
                'last_clearance_update',
                'checked_by',
            ]);
        });
    }
};
