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
        Schema::create('test_parameters', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('unit')->nullable();
            $table->decimal('default_min', 8, 2)->nullable();
            $table->decimal('default_max', 8, 2)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::table('test_parameters', function (Blueprint $table) {
            $table->index('code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_parameters');
    }
};