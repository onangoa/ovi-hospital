<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClinicianIdToLabRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lab_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('clinician_id')->nullable()->after('clinician_name');
            $table->foreign('clinician_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lab_requests', function (Blueprint $table) {
            $table->dropForeign(['clinician_id']);
            $table->dropColumn('clinician_id');
        });
    }
}
