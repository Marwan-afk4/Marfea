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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email');
            $table->string('password');
            $table->string('phone')->nullable();
            $table->string('email_code', 45)->nullable();
            $table->enum('email_verified',['verified', 'unverified'])->nullable();
            $table->string('image')->nullable();
            $table->enum('status',['pending', 'approved', 'rejected','suspended','active','inactive','deleted'])->default('pending');
            $table->enum('role',['admin', 'user','employeer'])->default('user');
            $table->string('id_token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
