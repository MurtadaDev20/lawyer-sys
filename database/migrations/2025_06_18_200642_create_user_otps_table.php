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
        Schema::create('user_otps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->unsignedTinyInteger('otp_type')->index();
            $table->char('otp_code', 6);
            $table->string('send_to_phone', 25)->index();
            $table->boolean('is_otp_verified')->default(false);
            $table->unsignedTinyInteger('failed_attempts_count')->default(0);
            $table->unsignedTinyInteger('resend_count')->default(0);
            $table->timestamp('last_failed_attempt_date', 0)->nullable();
            $table->timestamp('last_resend_date', 0)->nullable();
            $table->timestamp('verified_at', 0)->nullable();
            $table->timestamp('created_at', 0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_otps');
    }
};
