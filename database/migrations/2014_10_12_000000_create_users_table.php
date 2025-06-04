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
    // kegunaan up adalah untuk medefinisikan perubahan dari database
    // kegunaan down adalah untuk membatalkan perubahan yang di definisikan di kegunaan up
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->enum('role', ['admin', 'cashier']);
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
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
