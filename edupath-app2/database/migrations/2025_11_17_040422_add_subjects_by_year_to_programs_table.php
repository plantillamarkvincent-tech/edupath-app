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
        Schema::table('programs', function (Blueprint $table) {
            // Add the subjects_by_year column as nullable text
            $table->text('subjects_by_year')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            // Drop the subjects_by_year column if it exists
            if (Schema::hasColumn('programs', 'subjects_by_year')) {
                $table->dropColumn('subjects_by_year');
            }
        });
    }
};
