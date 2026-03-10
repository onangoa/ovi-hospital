<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveGroupParticipantsAndSignatureFromTherapyReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('therapy_reports', function (Blueprint $table) {
            $table->dropColumn('group_participants');
            $table->dropColumn('physiotherapist_signature');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('therapy_reports', function (Blueprint $table) {
            $table->text('group_participants')->nullable();
            $table->string('physiotherapist_signature')->nullable();
        });
    }
}
