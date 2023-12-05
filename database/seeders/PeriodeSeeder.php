<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeriodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['tahun' => 2024, 'nama' => '2024-2025', 'keterangan' => 'periode 1'],
            ['tahun' => 2025, 'nama' => '2025-2026', 'keterangan' => 'periode 2'],
            ['tahun' => 2026, 'nama' => '2026-2027', 'keterangan' => 'periode 3'],
        ];

        foreach ($data as $item) {
            DB::table('periode')->insert($item);
        }
    }
}