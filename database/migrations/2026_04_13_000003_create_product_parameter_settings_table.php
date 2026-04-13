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
        Schema::create('product_parameter_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('test_parameter_id')->constrained('test_parameters')->cascadeOnDelete();
            $table->decimal('min_value', 8, 2)->nullable();
            $table->decimal('max_value', 8, 2)->nullable();
            $table->timestamps();

            $table->unique(['product_id', 'test_parameter_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_parameter_settings');
    }
};