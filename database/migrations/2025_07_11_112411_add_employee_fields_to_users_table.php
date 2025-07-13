<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nama_bank')->nullable();
            $table->string('nomor_rekening')->nullable();
            $table->string('scan_ktp')->nullable();
            $table->string('scan_npwp')->nullable();
        });
    }

    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['npwp', 'nama_bank', 'nomor_rekening', 'scan_ktp', 'scan_npwp', 'dokumen_kontrak']);
        });
    }
};
?>