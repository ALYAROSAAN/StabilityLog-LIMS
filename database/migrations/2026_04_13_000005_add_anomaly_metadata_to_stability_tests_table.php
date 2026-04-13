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
        Schema::table('stability_tests', function (Blueprint $table) {
            $table->dateTime('performed_at')->nullable()->after('schedule_date');
            $table->boolean('is_anomaly')->default(false)->after('status');
            $table->string('result_status')->nullable()->after('is_anomaly');
            $table->text('notes')->nullable()->after('result_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stability_tests', function (Blueprint $table) {
            $table->dropColumn(['performed_at', 'is_anomaly', 'result_status', 'notes']);
        });
    }
};