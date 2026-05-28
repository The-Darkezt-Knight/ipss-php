<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('client', function (Blueprint $table) {
            if (!Schema::hasColumn('client', 'location_accuracy')) {
                $table->decimal('location_accuracy', 10, 2)->nullable()->after('longitude');
            }

            if (!Schema::hasColumn('client', 'location_captured_at')) {
                $table->timestamp('location_captured_at')->nullable()->after('location_accuracy');
            }
        });
    }

    public function down(): void
    {
        Schema::table('client', function (Blueprint $table) {
            if (Schema::hasColumn('client', 'location_captured_at')) {
                $table->dropColumn('location_captured_at');
            }

            if (Schema::hasColumn('client', 'location_accuracy')) {
                $table->dropColumn('location_accuracy');
            }
        });
    }
};
