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
        Schema::create('vital_sign_configs', function (Blueprint $table) {
            $table->id();
            $table->string('field_name');
            $table->string('display_name');
            $table->string('field_type'); // text, number, select, etc.
            $table->json('field_options')->nullable(); // For select fields
            $table->decimal('min_value', 8, 2)->nullable();
            $table->decimal('max_value', 8, 2)->nullable();
            $table->string('unit')->nullable();
            $table->integer('display_order')->default(0);
            $table->boolean('is_required')->default(false);
            $table->boolean('is_active')->default(true);
            $table->string('category')->default('general'); // general, pediatric, adult, etc.
            $table->timestamps();
            
            $table->unique(['field_name', 'category']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vital_sign_configs');
    }
};