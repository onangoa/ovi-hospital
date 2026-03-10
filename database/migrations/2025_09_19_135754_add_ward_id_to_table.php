<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWardIdToTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('patient_appointments', function (Blueprint $table) {
            $table->foreignId('ward_id')
                  ->nullable()
                  ->constrained('wards')
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
        Schema::table('patient_appointments', function (Blueprint $table) {
            $table->dropForeign(['ward_id']);
            $table->dropColumn('ward_id');
        });
    }
}
