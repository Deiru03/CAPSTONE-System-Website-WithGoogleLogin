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
        Schema::table('uploaded_clearances', function (Blueprint $table) {
            $table->year('academic_year')->nullable();
            $table->enum('semester', ['1st', '2nd', '3rd'])->nullable();
            $table->date('archive_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('uploaded_clearances', function (Blueprint $table) {
            $table->dropColumn(['academic_year', 'semester', 'archive_date']);
        });
    }
};
