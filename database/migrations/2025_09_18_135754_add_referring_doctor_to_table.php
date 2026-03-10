<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReferringDoctorToTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medical_referrals', function (Blueprint $table) {
            $table->foreignId('referring_doctor_id')
                  ->nullable()
                  ->constrained('users')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medical_referals', function (Blueprint $table) {
            $table->dropForeign(['referring_doctor_id']);
            $table->dropColumn('referring_doctor_id');
        });
    }
}
