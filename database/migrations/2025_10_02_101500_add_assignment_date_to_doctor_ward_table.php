<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAssignmentDateToDoctorWardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('doctor_ward', function (Blueprint $table) {
            $table->date('appointment_date')->nullable()->after('slot_time');
            $table->index(['doctor_id', 'appointment_date', 'slot_time']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('doctor_ward', function (Blueprint $table) {
            $table->dropIndex(['doctor_id', 'appointment_date', 'slot_time']);
            $table->dropColumn('appointment_date');
        });
    }
}