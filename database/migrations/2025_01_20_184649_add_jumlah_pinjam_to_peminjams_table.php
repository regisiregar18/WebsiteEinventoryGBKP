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
        Schema::table('peminjams', function (Blueprint $table) {
            $table->integer('jumlah_pinjam')->default(0); // Menambahkan kolom jumlah_pinjam
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('peminjams', function (Blueprint $table) {
            $table->dropColumn('jumlah_pinjam'); // Menghapus kolom jumlah_pinjam jika migrasi di-rollback
        });
    }
};
