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
        Schema::table('company_specializations', function (Blueprint $table) {
            $table->dropColumn(['specialization_name']);
            $table->foreignId('specialization_id')->constrained('specializations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_specializations', function (Blueprint $table) {
            //
        });
    }
};
