<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhysiotherapistIdToTherapyReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('therapy_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('physiotherapist_id')->nullable();
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
            $table->dropColumn('physiotherapist_id');
        });
    }
}
