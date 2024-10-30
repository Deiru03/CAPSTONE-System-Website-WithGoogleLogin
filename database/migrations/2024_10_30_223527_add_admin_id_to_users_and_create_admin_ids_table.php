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
        // Add admin_id_registered column to users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('admin_id_registered')->nullable()->after('checked_by');
        });

        // Create admin_ids table
        Schema::create('admin_ids', function (Blueprint $table) {
            $table->id();
            $table->string('admin_id')->unique();
            $table->boolean('is_assigned')->default(false);
            $table->timestamps();
        });
    }
    
     /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop admin_id_registered column from users table
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('admin_id_registered');
        });

        // Drop admin_ids table
        Schema::dropIfExists('admin_ids');
    }
};
