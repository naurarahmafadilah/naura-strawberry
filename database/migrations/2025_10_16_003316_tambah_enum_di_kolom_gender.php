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
        Schema::table('pelanggan', function (Blueprint $table) {
            // Menambahkan 'Prefer not to say' ke daftar ENUM yang sudah ada
            $table->enum('gender', ['Pria', 'Wanita', 'Lainnya', 'Non-Binar'])
                  ->nullable()
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelanggan', function (Blueprint $table) {
            // Mengembalikan ke definisi ENUM semula jika migration di-rollback
            $table->enum('gender', ['Male', 'Female', 'Other'])
                  ->nullable()
                  ->change();
        });
    }
};
