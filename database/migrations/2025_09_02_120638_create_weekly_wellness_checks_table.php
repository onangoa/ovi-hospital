<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeeklyWellnessChecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weekly_wellness_checks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->date('date')->nullable();
            $table->string('conducted_by')->nullable();
            $table->text('vital_signs')->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->boolean('full_meals')->default(false);
            $table->boolean('partial_meals')->default(false);
            $table->boolean('minimal_meals')->default(false);
            $table->text('skin_wounds')->nullable();
            $table->string('mobility')->nullable();
            $table->text('mobility_notes')->nullable();
            $table->text('sleep')->nullable();
            $table->text('mood')->nullable();
            $table->text('engagement')->nullable();
            $table->text('behavior_changes')->nullable();
            $table->text('with_caregivers')->nullable();
            $table->text('with_peers')->nullable();
            $table->text('communication')->nullable();
            $table->text('pain_indicators')->nullable();
            $table->text('comfort')->nullable();
            $table->text('medication')->nullable();
            $table->text('signs_of_illness')->nullable();
            $table->text('hydration')->nullable();
            $table->text('environment')->nullable();
            $table->text('progress')->nullable();
            $table->text('next_steps')->nullable();
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
        Schema::dropIfExists('weekly_wellness_checks');
    }
}
