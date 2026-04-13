<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('test_parameters')) {
            DB::table('test_parameters')->upsert([
                [
                    'code' => 'ph',
                    'name' => 'pH',
                    'unit' => null,
                    'default_min' => 0.00,
                    'default_max' => 14.00,
                    'description' => 'Nilai pH harus berada di rentang 0.0–14.0 untuk stabilitas produk.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'code' => 'viscosity',
                    'name' => 'Viskositas',
                    'unit' => 'cP',
                    'default_min' => null,
                    'default_max' => null,
                    'description' => 'Parameter viskositas untuk produk skincare.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'code' => 'organoleptic',
                    'name' => 'Organoleptik',
                    'unit' => null,
                    'default_min' => null,
                    'default_max' => null,
                    'description' => 'Pengamatan organoleptik seperti aroma, warna, dan tekstur.',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ], ['code'], ['name', 'unit', 'default_min', 'default_max', 'description', 'updated_at']);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('test_parameters')->whereIn('code', ['ph', 'viscosity', 'organoleptic'])->delete();
    }
};