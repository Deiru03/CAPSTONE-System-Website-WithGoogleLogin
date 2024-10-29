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
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->string('title')->nullable();
            $table->string('status')->nullable();
            $table->string('transaction_type');
            $table->timestamps();
    
            $table->foreign('user_id')
                  ->references('id')->on('users')->onDelete('cascade');
            $table->foreign('admin_id')
                  ->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('submitted_reports');
    }
};
