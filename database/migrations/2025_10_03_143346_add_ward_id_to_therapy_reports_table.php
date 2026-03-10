<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWardIdToTherapyReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('therapy_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('ward_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('therapy_reports', function (Blueprint $table) {
            $table->dropColumn('ward_id');
        });
    }
}
