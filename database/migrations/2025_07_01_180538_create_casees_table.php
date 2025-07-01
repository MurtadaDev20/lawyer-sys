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
        Schema::create('casees', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('case_number')->unique()->nullable();

            $table->foreignId('case_type_id')->nullable();
            $table->foreignId('case_status_id')->nullable();

            $table->foreignId('lawyer_id')->nullable();
            $table->foreignId('customer_id')->nullable();

            $table->date('start_date')->nullable();
            $table->date('due_date')->nullable();
            $table->date('closed_date')->nullable();

            $table->string('court_name')->nullable();
            $table->string('location')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('casees');
    }
};
