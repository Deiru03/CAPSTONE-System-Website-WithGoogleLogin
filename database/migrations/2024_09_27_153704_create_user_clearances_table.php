<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserClearancesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_clearances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shared_clearance_id');
            $table->unsignedBigInteger('user_id');
            $table->string('status')->default('pending'); // Add this line for the status column
            $table->boolean('is_active')->default(false);
            $table->timestamps();
            $table->foreign('shared_clearance_id')->references('id')->on('shared_clearances')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Ensure a user can get a copy of a clearance only once
            $table->unique(['shared_clearance_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_clearances');
    }
};