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
        Schema::table('enrollment_requests', function (Blueprint $table) {
            // Convert some VARCHAR fields to TEXT to reduce row size
            $table->text('permanent_address')->change();
            $table->text('address')->change();
            $table->text('last_school_attended')->change();
            $table->text('student_photo')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enrollment_requests', function (Blueprint $table) {
            $table->string('permanent_address')->change();
            $table->string('address')->change();
            $table->string('last_school_attended')->change();
            $table->string('student_photo')->change();
        });
    }
};