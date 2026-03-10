<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->unsignedBigInteger('ward_id')->nullable();
            $table->unsignedBigInteger('company_id')->nullable()->default(1);
            
            // Assignment details
            $table->string('weekday')->nullable();
            $table->time('start_time');
            $table->time('end_time')->nullable();
            
            // Appointment specific fields
            $table->date('appointment_date')->nullable();
            $table->text('problem')->nullable();
            $table->enum('status', ['scheduled', 'in_progress', 'completed', 'cancelled'])->default('scheduled');
            
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('doctor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('ward_id')->references('id')->on('wards')->onDelete('cascade');
            
            // Indexes
            $table->index(['doctor_id', 'weekday']);
            $table->index(['patient_id', 'appointment_date']);
            $table->index(['ward_id', 'weekday']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctor_assignments');
    }
}