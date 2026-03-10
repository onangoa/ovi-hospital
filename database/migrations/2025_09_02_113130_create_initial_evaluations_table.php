<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInitialEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('initial_evaluations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->date('date');
            $table->string('provider_name')->nullable();
            $table->text('reason_for_treatment')->nullable();
            $table->text('social_background')->nullable();
            $table->decimal('temperature', 5, 2)->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->integer('heart_rate')->nullable();
            $table->integer('respiratory_rate')->nullable();
            $table->decimal('spo2', 5, 2)->nullable();
            $table->text('skin_condition')->nullable();
            $table->string('edema')->nullable();
            $table->string('nutritional_status')->nullable();
            $table->text('pain_signs')->nullable();
            $table->string('hydration')->nullable();
            $table->integer('pain_level')->nullable();
            $table->string('pain_location')->nullable();
            $table->string('mobility')->nullable();
            $table->string('respiratory')->nullable();
            $table->string('cardiovascular')->nullable();
            $table->string('neurological')->nullable();
            $table->string('gastrointestinal')->nullable();
            $table->string('musculoskeletal')->nullable();
            $table->string('skin')->nullable();
            $table->text('primary_diagnosis')->nullable();
            $table->text('secondary_diagnosis')->nullable();
            $table->text('chronic_conditions')->nullable();
            $table->text('current_medications')->nullable();
            $table->text('allergies')->nullable();
            $table->string('bathing')->nullable();
            $table->string('dressing')->nullable();
            $table->string('eating')->nullable();
            $table->string('mobility_transfers')->nullable();
            $table->string('toileting')->nullable();
            $table->boolean('physical_therapy')->default(false);
            $table->boolean('psychiatric_support')->default(false);
            $table->boolean('virtual_therapy')->default(false);
            $table->boolean('other_therapy')->default(false);
            $table->text('other_therapy_comments')->nullable();
            $table->string('emotional_state')->nullable();
            $table->string('engagement')->nullable();
            $table->string('peer_interaction')->nullable();
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
        Schema::dropIfExists('initial_evaluations');
    }
}
