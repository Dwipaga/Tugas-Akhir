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
            $table->string('id_karyawan', 50)->nullable()->after('user_id');
            $table->date('tanggal_lahir')->nullable()->after('id_karyawan');
            $table->date('tanggal_masuk')->nullable()->after('tanggal_lahir');
            $table->date('tanggal_akhir_kontrak')->nullable()->after('tanggal_masuk');
            $table->string('npwp', 20)->nullable()->after('tanggal_akhir_kontrak');
            $table->string('jenis_kontrak', 50)->nullable()->after('npwp');
            $table->string('dokumen_kontrak', 100)->nullable()->after('jenis_kontrak');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
