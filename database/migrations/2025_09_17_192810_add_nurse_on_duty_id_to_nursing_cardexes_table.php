<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNurseOnDutyIdToNursingCardexesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nursing_cardexes', function (Blueprint $table) {
            $table->unsignedBigInteger('nurse_on_duty_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nursing_cardexes', function (Blueprint $table) {
            $table->dropColumn('nurse_on_duty_id');
        });
    }
}
