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
        Schema::table('workshops', function (Blueprint $table) {
            $table->string('category')->nullable();
            $table->text('description')->nullable();
            $table->string('time')->nullable();
            $table->integer('duration')->nullable();
            $table->string('type')->nullable(); // online, offline
            $table->string('instructor_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workshops', function (Blueprint $table) {
            $table->dropColumn(['category', 'description', 'time', 'duration', 'type', 'instructor_name']);
        });
    }
};
