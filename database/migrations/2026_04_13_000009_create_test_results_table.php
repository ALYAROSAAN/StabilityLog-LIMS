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
        Schema::create('test_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stability_test_id')->constrained('stability_tests')->cascadeOnDelete()->unique();
            $table->foreignId('testing_parameter_id')->constrained('testing_parameters')->cascadeOnDelete();
            $table->double('value')->nullable();
            $table->boolean('is_anomaly')->default(false);
            $table->timestamps();

            $table->index(['stability_test_id', 'testing_parameter_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_results');
    }
};