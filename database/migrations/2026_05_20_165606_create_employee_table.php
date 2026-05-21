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
        Schema::create('employee', function (Blueprint $table) {
            $table->id();
            $table->string('govt_id');
            $table->string('govt_email')->unique();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->integer('age');
            $table->date('birth_date');
            $table->string('baranggay')->nullable();
            $table->string('city_municipality');
            $table->string('province');
            $table->string('region');
            $table->string('sex');
            $table->string('password');
            $table->boolean('is_active')->default(true);
            $table->string('role')->default('EMPLOYEE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee');
    }
};
