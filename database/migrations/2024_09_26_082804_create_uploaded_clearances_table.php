<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadedClearancesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('uploaded_clearances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shared_clearance_id');
            $table->unsignedBigInteger('requirement_id');
            $table->unsignedBigInteger('user_id');
            $table->string('file_path');
            $table->string('status')->default('oncheck'); // Add this line for the status column
            $table->timestamps();
            

            $table->foreign('shared_clearance_id')
                ->references('id')
                ->on('shared_clearances')
                ->onDelete('cascade');
            
            $table->foreign('requirement_id')
                ->references('id')
                ->on('clearance_requirements')
                ->onDelete('cascade');
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        
        // Removed the unique constraint to allow multiple uploads per requirement
        // $table->unique(['shared_clearance_id', 'requirement_id', 'user_id'], 'unique_upload');
    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('uploaded_clearances');
    }
};
