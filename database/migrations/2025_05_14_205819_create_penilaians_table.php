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
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();
            $table->string('penilaian');
            $table->unsignedBigInteger('asesi_id');
            $table->unsignedBigInteger('asesor_id');
            $table->decimal('bobot', 5, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Assuming groups table exists for asesi and asesor
            $table->foreign('asesi_id')->references('group_id')->on('groups');
            $table->foreign('asesor_id')->references('group_id')->on('groups');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};