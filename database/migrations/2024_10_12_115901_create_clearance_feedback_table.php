<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClearanceFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('clearance_feedback', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('requirement_id');
            $table->unsignedBigInteger('user_id');
            $table->text('message')->nullable();
            $table->string('signature_status')->default('On Check');
            $table->timestamps();

            $table->foreign('requirement_id')
                  ->references('id')->on('clearance_requirements')->onDelete('cascade');
            $table->foreign('user_id')
                  ->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('clearance_feedback');
    }
};
