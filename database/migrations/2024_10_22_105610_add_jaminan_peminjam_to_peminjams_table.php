<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('peminjams', function (Blueprint $table) {
        $table->string('jaminan_peminjam')->nullable(); // Menambahkan kolom jaminan_peminjam
    });
}

public function down()
{
    Schema::table('peminjams', function (Blueprint $table) {
        $table->dropColumn('jaminan_peminjam');
    });
}
};
