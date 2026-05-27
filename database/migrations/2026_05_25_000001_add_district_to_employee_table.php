<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add district assignment columns to the employee table.
     * - district: stores the district name (e.g. "1st District") for display
     * - district_code: stores the district code (e.g. "0645-D1") for API filtering
     */
    public function up(): void
    {
        Schema::table('employee', function (Blueprint $table) {
            $table->string('district')->nullable()->after('region');
            $table->string('district_code')->nullable()->after('district');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee', function (Blueprint $table) {
            $table->dropColumn(['district', 'district_code']);
        });
    }
};
