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
        Schema::create('job_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->foreignId('job_category_id')->constrained('job_categories')->onDelete('cascade');
            $table->foreignId('city_id')->constrained('cities')->onDelete('cascade');
            $table->foreignId('zone_id')->constrained('zones')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('qualifications')->nullable();
            $table->string('image')->nullable();
            $table->enum('type',['full_time', 'part_time', 'freelance','hybrid','internship'])->nullable();
            $table->enum('level',['entry_level', 'intermediate', 'advanced','expert'])->nullable();
            $table->integer('min_expected_salary')->nullable();
            $table->integer('max_expected_salary')->nullable();
            $table->date('expire_date')->nullable();
            $table->enum('status',['active', 'inactive'])->default('active');
            $table->string('location_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_offers');
    }
};
