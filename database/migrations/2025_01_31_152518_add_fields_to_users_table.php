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
        Schema::table('users', function (Blueprint $table) {
            $table->string('posisi')->nullable();
            $table->string('outlet_cabang')->nullable();
            $table->integer('duration')->nullable();
            $table->string('nik')->unique()->nullable();
            $table->string('npwp')->unique()->nullable();
            $table->string('photo')->nullable();
            $table->string('role')->default('pegawai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'posisi',
                'outlet_cabang',
                'duration',
                'nik',
                'npwp',
                'photo',
                'role',
            ]);
        });
    }
};
