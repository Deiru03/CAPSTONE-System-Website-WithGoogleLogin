<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClearanceRequirementsTable extends Migration
{
    public function up()
    {
        Schema::create('clearance_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clearance_id')->constrained()->onDelete('cascade');
            $table->text('requirement');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clearance_requirements');
    }
}
