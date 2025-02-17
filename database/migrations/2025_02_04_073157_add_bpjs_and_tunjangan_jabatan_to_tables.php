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
        Schema::table('tables', function (Blueprint $table) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('bpjs')->nullable();
            });
    
            Schema::table('jabatans', function (Blueprint $table) {
                $table->integer('tunjangan_jabatan')->default(0);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('bpjs');
            });
    
            Schema::table('jabatan', function (Blueprint $table) {
                $table->dropColumn('tunjangan_jabatan');
            });
        });
    }
};
