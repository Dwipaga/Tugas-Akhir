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
        Schema::create('employee_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->json('contract_data')->nullable(); // Stores contract data as JSON
            $table->string('contract_path')->nullable(); // Path to the generated contract PDF
            $table->timestamp('generated_at')->nullable(); // When the contract was generated
            $table->enum('status', ['generated', 'signed', 'expired', 'terminated'])->default('generated');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_contracts');
    }
};