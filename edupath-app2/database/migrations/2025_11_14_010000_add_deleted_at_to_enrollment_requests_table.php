<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('enrollment_requests') && !Schema::hasColumn('enrollment_requests', 'deleted_at')) {
            Schema::table('enrollment_requests', function (Blueprint $table) {
                $table->softDeletes();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('enrollment_requests') && Schema::hasColumn('enrollment_requests', 'deleted_at')) {
            Schema::table('enrollment_requests', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
    }
};
