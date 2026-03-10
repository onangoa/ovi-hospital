<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaregiverDailyReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caregiver_daily_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('provider_id');
            $table->date('date');
            $table->string('breakfast')->nullable();
            $table->string('lunch')->nullable();
            $table->string('dinner')->nullable();
            $table->string('mood')->nullable();
            $table->string('favorite_activity')->nullable();
            $table->integer('pain_level')->nullable();
            $table->text('concerns')->nullable();
            $table->string('caregiver_signature')->nullable();
            $table->timestamps();
            
            $table->foreign('patient_id')->references('id')->on('users');
            $table->foreign('provider_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('caregiver_daily_reports');
    }
}
