<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('batch_code')->unique(); // Aturan Bisnis: Unik [cite: 50, 174]
        $table->text('barcode_qr')->nullable(); 
        $table->string('status')->default('Ready for Testing'); // Status Default [cite: 46, 373]
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
