<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employee', function (Blueprint $table) {
            if (!Schema::hasColumn('employee', 'current_location_updated_at')) {
                $table->timestamp('current_location_updated_at')->nullable()->after('current_longitude');
            }
        });
    }

    public function down(): void
    {
        Schema::table('employee', function (Blueprint $table) {
            if (Schema::hasColumn('employee', 'current_location_updated_at')) {
                $table->dropColumn('current_location_updated_at');
            }
        });
    }
};
