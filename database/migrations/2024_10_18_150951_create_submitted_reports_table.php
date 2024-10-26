<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubmittedReportsTable extends Migration
{
    public function up()
    {
        Schema::create('submitted_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('requirement_name'); // Change this line
            $table->string('uploaded_clearance_name'); // Change this line
            $table->string('title')->nullable();
            $table->string('status')->default('pending');
            $table->string('transaction_type');
            $table->timestamps();
    
            $table->foreign('user_id')
                  ->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('submitted_reports');
    }
};
