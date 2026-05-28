<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employee', function (Blueprint $table) {
            if (!Schema::hasColumn('employee', 'current_latitude')) {
                $table->decimal('current_latitude', 10, 7)->nullable()->after('district_code');
            }

            if (!Schema::hasColumn('employee', 'current_longitude')) {
                $table->decimal('current_longitude', 10, 7)->nullable()->after('current_latitude');
            }
        });
    }

    public function down(): void
    {
        Schema::table('employee', function (Blueprint $table) {
            if (Schema::hasColumn('employee', 'current_longitude')) {
                $table->dropColumn('current_longitude');
            }

            if (Schema::hasColumn('employee', 'current_latitude')) {
                $table->dropColumn('current_latitude');
            }
        });
    }
};
