<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('peminjamen', function (Blueprint $table) {
        $table->date('tgl_selesai')->nullable(); // Menambahkan kolom tgl_selesai
    });
}

public function down()
{
    Schema::table('peminjamen', function (Blueprint $table) {
        $table->dropColumn('tgl_selesai'); // Menghapus kolom saat rollback
    });
}

};
