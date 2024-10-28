<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsArchivedToUploadedClearancesAndFeedback extends Migration
{
    public function up()
    {
        Schema::table('uploaded_clearances', function (Blueprint $table) {
            $table->boolean('is_archived')->default(false);
        });

        Schema::table('clearance_feedback', function (Blueprint $table) {
            $table->boolean('is_archived')->default(false);
        });
    }

    public function down()
    {
        Schema::table('uploaded_clearances', function (Blueprint $table) {
            $table->dropColumn('is_archived');
        });

        Schema::table('clearance_feedback', function (Blueprint $table) {
            $table->dropColumn('is_archived');
        });
    }
};
