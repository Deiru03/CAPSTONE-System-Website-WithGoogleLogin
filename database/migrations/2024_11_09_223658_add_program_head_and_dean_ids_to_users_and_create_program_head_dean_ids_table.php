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
        // Add program_head_id and dean_id columns to users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('program_head_id')->nullable()->after('admin_id_registered');
            $table->string('dean_id')->nullable()->after('program_head_id');
        });

        // Create program_head_dean_ids table
        Schema::create('program_head_dean_ids', function (Blueprint $table) {
            $table->id();
            $table->string('identifier')->unique();
            $table->enum('type', ['Program-Head', 'Dean'])->nullable();
            $table->boolean('is_assigned')->default(false);
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop program_head_id and dean_id columns from users table
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['program_head_id', 'dean_id']);
        });

        // Drop program_head_dean_ids table
        Schema::dropIfExists('program_head_dean_ids');
     }
};
