<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clinical_form_vital_sign_pivot', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinical_form_vital_sign_id')->constrained('clinical_form_vital_signs')->onDelete('cascade')->name('cfvp_cfvs_id_foreign');
            $table->foreignId('vital_sign_config_id')->constrained('vital_sign_configs')->onDelete('cascade')->name('cfvp_vsc_id_foreign');
            $table->boolean('is_required')->default(false);
            $table->integer('display_order')->default(0);
            $table->timestamps();
            
            $table->unique(['clinical_form_vital_sign_id', 'vital_sign_config_id'], 'cfvp_cfvs_vsc_unique');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinical_form_vital_sign_pivot');
    }
};