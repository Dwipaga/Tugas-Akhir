<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asesi_ternilai_id');
            $table->unsignedBigInteger('penilai_id');
            $table->json('detail_penilaian');
            $table->decimal('total_akhir', 8, 2)->default(0);
            $table->date('bulan_penilaian')->index(); // Stores evaluation month (YYYY-MM-01)
            $table->timestamps();

            $table->foreign('asesi_ternilai_id')->references('user_id')->on('users');
            $table->foreign('penilai_id')->references('user_id')->on('users');
            $table->unique(['asesi_ternilai_id', 'penilai_id', 'bulan_penilaian'], 'unique_monthly_evaluation');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};