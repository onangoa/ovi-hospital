<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommentFieldsToInitialEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('initial_evaluations', function (Blueprint $table) {
            $table->text('respiratory_comments')->nullable()->after('respiratory');
            $table->text('cardiovascular_comments')->nullable()->after('cardiovascular');
            $table->text('neurological_comments')->nullable()->after('neurological');
            $table->text('gastrointestinal_comments')->nullable()->after('gastrointestinal');
            $table->text('musculoskeletal_comments')->nullable()->after('musculoskeletal');
            $table->text('skin_comments')->nullable()->after('skin');
            $table->text('bathing_comments')->nullable()->after('bathing');
            $table->text('dressing_comments')->nullable()->after('dressing');
            $table->text('eating_comments')->nullable()->after('eating');
            $table->text('mobility_transfers_comments')->nullable()->after('mobility_transfers');
            $table->text('toileting_comments')->nullable()->after('toileting');
            $table->text('emotional_state_comments')->nullable()->after('emotional_state');
            $table->text('engagement_comments')->nullable()->after('engagement');
            $table->text('peer_interaction_comments')->nullable()->after('peer_interaction');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('initial_evaluations', function (Blueprint $table) {
            $table->dropColumn([
                'respiratory_comments',
                'cardiovascular_comments',
                'neurological_comments',
                'gastrointestinal_comments',
                'musculoskeletal_comments',
                'skin_comments',
                'bathing_comments',
                'dressing_comments',
                'eating_comments',
                'mobility_transfers_comments',
                'toileting_comments',
                'emotional_state_comments',
                'engagement_comments',
                'peer_interaction_comments'
            ]);
        });
    }
}