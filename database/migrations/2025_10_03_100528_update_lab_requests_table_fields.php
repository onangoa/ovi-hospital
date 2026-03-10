<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLabRequestsTableFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lab_requests', function (Blueprint $table) {
            // Add the new specimen column
            $table->text('specimen')->nullable()->after('resident');
            
            // Remove the old columns
            $table->dropColumn([
                'report_to',
                'specimen_type',
                'collection_datetime',
                'specimen_no'
            ]);
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
            // Add back the old columns
            $table->string('report_to')->nullable()->after('resident');
            $table->string('specimen_type')->nullable()->after('report_to');
            $table->dateTime('collection_datetime')->nullable()->after('specimen_type');
            $table->string('specimen_no')->nullable()->after('collection_datetime');
            
            // Remove the specimen column
            $table->dropColumn('specimen');
        });
    }
}
