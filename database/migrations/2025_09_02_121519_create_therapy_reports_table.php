<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTherapyReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('therapy_reports', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->string('physiotherapist_signature')->nullable();
            $table->string('session_time')->nullable();
            $table->text('session_summary')->nullable();
            $table->text('group_participants')->nullable();
            $table->text('group_session_summary')->nullable();
            $table->text('overall_observations')->nullable();
            $table->text('equipment_clean_up')->nullable();
            $table->text('additional_comments')->nullable();
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
        Schema::dropIfExists('therapy_reports');
    }
}
