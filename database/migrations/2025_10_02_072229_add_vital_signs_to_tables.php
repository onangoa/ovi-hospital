<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVitalSignsToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('initial_evaluations', function (Blueprint $table) {
            $table->json('vital_signs')->nullable();
        });
        Schema::table('lab_requests', function (Blueprint $table) {
            $table->json('vital_signs')->nullable();
        });
        Schema::table('ward_round_notes', function (Blueprint $table) {
            $table->json('vital_signs')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('initial_evaluations', function (Blueprint $table) {
            $table->dropColumn('vital_signs');
        });
        Schema::table('lab_requests', function (Blueprint $table) {
            $table->dropColumn('vital_signs');
        });
        Schema::table('ward_round_notes', function (Blueprint $table) {
            $table->dropColumn('vital_signs');
        });
    }
}
