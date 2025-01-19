<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('peminjams', function (Blueprint $table) {
        $table->string('no_wa')->nullable(); // Tidak menggunakan after
    });
}

public function down()
{
    Schema::table('peminjams', function (Blueprint $table) {
        $table->dropColumn('no_wa');
    });
}
};
