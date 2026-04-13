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
        Schema::create('stability_test_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stability_test_id')->constrained('stability_tests')->cascadeOnDelete();
            $table->foreignId('test_parameter_id')->constrained('test_parameters')->cascadeOnDelete();
            $table->decimal('value', 12, 4)->nullable();
            $table->string('value_text')->nullable();
            $table->boolean('is_anomaly')->default(false);
            $table->string('status')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['stability_test_id', 'test_parameter_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stability_test_results');
    }
};