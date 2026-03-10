<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNursingCardexesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nursing_cardexes', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            $table->json('vital_signs')->nullable();
            $table->text('brief_report')->nullable();
            $table->string('nurse_on_duty_name')->nullable();
            $table->time('duty_end_time')->nullable();
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
        Schema::dropIfExists('nursing_cardexes');
    }
}
