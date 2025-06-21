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
        Schema::table('job_offers', function (Blueprint $table) {
            $table->dropColumn('min_expected_salary');
            $table->dropColumn('max_expected_salary');
            $table->dropColumn('level');
            $table->enum('experience',['fresh','junior','mid','+1 year','+2 years','+3 years','senior'])->after('type');
            $table->decimal('expected_salary', 10, 2)->nullable()->after('salary')->after('experience');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jop_offers', function (Blueprint $table) {
            //
        });
    }
};
