<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('care_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->date('date');
            $table->string('medication_name')->nullable();
            $table->string('dosage')->nullable();
            $table->string('frequency')->nullable();
            $table->string('duration')->nullable();
            $table->text('special_instructions')->nullable();
            $table->text('dietary_needs')->nullable();
            $table->text('activity_restrictions')->nullable();
            $table->text('wound_care')->nullable();
            $table->string('admission_decision')->nullable();
            $table->string('tests_needed')->nullable();
            $table->text('tests_comments')->nullable();
            $table->string('provider_signature')->nullable();
            $table->dateTime('signature_date')->nullable();
            $table->timestamps();
            
            $table->foreign('patient_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('care_plans');
    }
}
