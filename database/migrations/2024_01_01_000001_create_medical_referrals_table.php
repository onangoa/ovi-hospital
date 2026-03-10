<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalReferralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            $table->text('reason_for_referral')->nullable();
            $table->text('chief_complaint')->nullable();
            $table->text('patient_brief_history')->nullable();
            $table->json('vital_signs')->nullable();
            $table->text('lab_investigation_done')->nullable();
            $table->text('treatment_done')->nullable();
            $table->string('referring_doctor_name')->nullable();
            $table->string('signature')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_referrals');
    }
}
