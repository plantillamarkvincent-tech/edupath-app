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
            // Make address nullable if it exists
            if (Schema::hasColumn('enrollment_requests', 'address')) {
                $table->string('address')->nullable()->change();
            }
            
            // Make contact_number nullable if it exists
            if (Schema::hasColumn('enrollment_requests', 'contact_number')) {
                $table->string('contact_number')->nullable()->change();
            }
            
            // Make full_name nullable if it exists
            if (Schema::hasColumn('enrollment_requests', 'full_name')) {
                $table->string('full_name')->nullable()->change();
            }

            // Make last_school_attended nullable if it exists
            if (Schema::hasColumn('enrollment_requests', 'last_school_attended')) {
                $table->string('last_school_attended')->nullable()->change();
            }

            // Make school_year nullable if it exists
            if (Schema::hasColumn('enrollment_requests', 'school_year')) {
                $table->string('school_year')->nullable()->change();
            }

            // Make permanent_address nullable if it exists
            if (Schema::hasColumn('enrollment_requests', 'permanent_address')) {
                $table->text('permanent_address')->nullable()->change();
            }

            // Make student_photo nullable if it exists
            if (Schema::hasColumn('enrollment_requests', 'student_photo')) {
                $table->text('student_photo')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enrollment_requests', function (Blueprint $table) {
            // Revert changes if needed
            if (Schema::hasColumn('enrollment_requests', 'address')) {
                $table->string('address')->nullable(false)->change();
            }
            
            if (Schema::hasColumn('enrollment_requests', 'contact_number')) {
                $table->string('contact_number')->nullable(false)->change();
            }
            
            if (Schema::hasColumn('enrollment_requests', 'full_name')) {
                $table->string('full_name')->nullable(false)->change();
            }

            if (Schema::hasColumn('enrollment_requests', 'last_school_attended')) {
                $table->string('last_school_attended')->nullable(false)->change();
            }

            if (Schema::hasColumn('enrollment_requests', 'school_year')) {
                $table->string('school_year')->nullable(false)->change();
            }

            if (Schema::hasColumn('enrollment_requests', 'permanent_address')) {
                $table->text('permanent_address')->nullable(false)->change();
            }

            if (Schema::hasColumn('enrollment_requests', 'student_photo')) {
                $table->text('student_photo')->nullable(false)->change();
            }
        });
    }
};
