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
        Schema::table('medicines', function (Blueprint $table) {
            // Cek apakah kolom 'review' ada sebelum mengubahnya
            if (Schema::hasColumn('medicines', 'review')) {
                $table->string('review')->default('Bagus')->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            // Hapus kolom 'review' jika ada
            if (Schema::hasColumn('medicines', 'review')) {
                $table->dropColumn('review');
            }
        });
    }
};
