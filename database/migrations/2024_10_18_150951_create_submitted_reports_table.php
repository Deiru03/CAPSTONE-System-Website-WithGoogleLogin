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
            $table->unsignedBigInteger('requirement_id');
            $table->unsignedBigInteger('uploaded_clearance_id');
            $table->string('title')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')->on('users')->onDelete('cascade');
            $table->foreign('requirement_id')
                  ->references('id')->on('clearance_requirements')->onDelete('cascade');
            $table->foreign('uploaded_clearance_id')
                  ->references('id')->on('uploaded_clearances')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('submitted_reports');
    }
};
