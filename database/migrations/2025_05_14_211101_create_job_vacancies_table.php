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
        Schema::create('job_vacancies', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pekerjaan');
            $table->enum('jenis_pekerjaan', ['kontrak', 'internship', 'fulltime']);
            $table->text('deskripsi');
            $table->string('divisi');
            $table->integer('min_pengalaman')->default(0);
            $table->date('ditutup_pada');
            $table->boolean('is_active')->default(true);
            $table->text('deskripsi_pekerjaan');
            $table->string('contact_person');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_vacancies');
    }
};