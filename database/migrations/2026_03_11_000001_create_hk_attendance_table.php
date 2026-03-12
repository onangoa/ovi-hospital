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
        Schema::create('hk_attendance', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address')->nullable();
            $table->integer('port_no')->nullable();
            $table->string('protocol')->nullable();
            $table->dateTime('date_time')->nullable();
            $table->string('event_type')->nullable();
            $table->string('event_state')->nullable();
            $table->string('event_description')->nullable();
            $table->string('device_name')->nullable();
            $table->integer('major_event_type')->nullable();
            $table->integer('sub_event_type')->nullable();
            $table->integer('card_type')->nullable();
            $table->integer('card_reader_no')->nullable();
            $table->integer('door_no')->nullable();
            $table->string('employee_no_string')->nullable();
            $table->integer('serial_no')->nullable()->unique();
            $table->string('user_type')->nullable();
            $table->string('attendance_status')->nullable();
            $table->integer('status_value')->nullable();
            $table->integer('pictures_number')->nullable();
            $table->boolean('pure_pwd_verify_enable')->nullable();
            $table->json('raw_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hk_attendance');
    }
};
