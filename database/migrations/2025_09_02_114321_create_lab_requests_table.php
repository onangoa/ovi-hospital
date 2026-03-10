<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->string('age')->nullable();
            $table->string('sex')->nullable();
            $table->string('resident')->nullable();
            $table->string('report_to')->nullable();
            $table->string('specimen_type')->nullable();
            $table->dateTime('collection_datetime')->nullable();
            $table->string('specimen_no')->nullable();
            $table->boolean('blood_bank')->default(false);
            $table->boolean('histology')->default(false);
            $table->boolean('serology')->default(false);
            $table->boolean('haematology')->default(false);
            $table->boolean('bacteriology')->default(false);
            $table->boolean('parasitology')->default(false);
            $table->boolean('biochemistry')->default(false);
            $table->string('other_destination')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('hb')->nullable();
            $table->text('investigation_requested')->nullable();
            $table->text('differential_diagnosis')->nullable();
            $table->string('clinician_name')->nullable();
            $table->date('request_date')->nullable();
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
        Schema::dropIfExists('lab_requests');
    }
}
