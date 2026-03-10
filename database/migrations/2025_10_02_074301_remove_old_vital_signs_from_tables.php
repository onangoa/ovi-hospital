<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveOldVitalSignsFromTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('initial_evaluations', function (Blueprint $table) {
            $table->dropColumn(['temperature', 'weight', 'heart_rate', 'respiratory_rate', 'spo2', 'pain_level']);
        });

        Schema::table('ward_round_notes', function (Blueprint $table) {
            $table->dropColumn(['temperature', 'weight', 'heart_rate', 'respiratory_rate', 'spo2', 'pain_level']);
        });

        Schema::table('lab_requests', function (Blueprint $table) {
            $table->dropColumn(['blood_group', 'hb']);
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
            $table->decimal('temperature', 5, 2)->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->integer('heart_rate')->nullable();
            $table->integer('respiratory_rate')->nullable();
            $table->integer('spo2')->nullable();
            $table->integer('pain_level')->nullable();
        });

        Schema::table('ward_round_notes', function (Blueprint $table) {
            $table->decimal('temperature', 5, 2)->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->integer('heart_rate')->nullable();
            $table->integer('respiratory_rate')->nullable();
            $table->integer('spo2')->nullable();
            $table->integer('pain_level')->nullable();
        });

        Schema::table('lab_requests', function (Blueprint $table) {
            $table->string('blood_group')->nullable();
            $table->string('hb')->nullable();
        });
    }
}
