<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWardRoundNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ward_round_notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->date('date')->nullable();
            $table->string('mrn')->nullable();
            $table->string('bed_number')->nullable();
            $table->string('attending_clinician')->nullable();
            $table->decimal('temperature', 5, 2)->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->integer('heart_rate')->nullable();
            $table->integer('respiratory_rate')->nullable();
            $table->integer('spo2')->nullable();
            $table->integer('pain_level')->nullable();
            $table->text('main_complaints')->nullable();
            $table->text('examination_findings')->nullable();
            $table->string('respiratory_status')->nullable();
            $table->text('respiratory_comments')->nullable();
            $table->string('cardiovascular_status')->nullable();
            $table->text('cardiovascular_comments')->nullable();
            $table->string('neurological_status')->nullable();
            $table->text('neurological_comments')->nullable();
            $table->string('gastrointestinal_status')->nullable();
            $table->text('gastrointestinal_comments')->nullable();
            $table->string('skin_status')->nullable();
            $table->text('skin_comments')->nullable();
            $table->text('medications_changes')->nullable();
            $table->text('procedures_interventions')->nullable();
            $table->text('pending_tests')->nullable();
            $table->string('condition')->nullable();
            $table->text('next_steps')->nullable();
            $table->string('clinician_name')->nullable();
            $table->string('signature')->nullable();
            $table->timestamps();
            
            $table->foreign('patient_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ward_round_notes');
    }
}
