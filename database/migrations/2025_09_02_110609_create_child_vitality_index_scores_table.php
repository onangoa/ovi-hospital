<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChildVitalityIndexScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('child_vitality_index_scores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->date('date');
            $table->string('nutritionalStatus');
            $table->string('developmentallyDelayed');
            $table->string('chronicConditions');
            $table->string('mentalHealth');
            $table->string('physicalDisabilities');
            $table->string('communicationAbilities');
            $table->string('vaccineStatus');
            $table->string('familialInstability');
            $table->string('poverty');
            $table->string('institutionalized');
            $table->string('insecureShelter');
            $table->string('psychologicalTrauma');
            $table->string('socialIsolation');
            $table->string('discrimination');
            $table->string('conflictArea');
            $table->string('healthcareAccess');
            $table->string('waterSource');
            $table->string('sanitation');
            $table->string('schoolStatus');
            $table->string('diseaseOutbreaks');
            $table->integer('score');
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('cvis');
    }
}
