<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdminIdToSubmittedReportsTable extends Migration
{
    public function up()
    {
        Schema::table('submitted_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('admin_id')->nullable()->after('user_id');
            $table->foreign('admin_id')
                  ->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('submitted_reports', function (Blueprint $table) {
            $table->dropForeign(['admin_id']);
            $table->dropColumn('admin_id');
        });
    }
};
