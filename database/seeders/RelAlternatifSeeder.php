<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RelAlternatifSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [457, 2024, 'K3', 'C5', 6],
            [426, 2024, 'A5', 'C5', 8],
            [421, 2024, 'A4', 'C5', 9],
            [416, 2024, 'A3', 'C5', 8],
            [402, 2024, 'A#', 'C1', -1],
            [456, 2024, 'K3', 'C4', 8],
            [453, 2024, 'K3', 'C1', 8],
            [447, 2024, 'K1', 'C5', 9],
            [425, 2024, 'A5', 'C4', 9],
            [406, 2024, 'A#', 'C5', -1],
            [415, 2024, 'A3', 'C4', 7],
            [413, 2024, 'A3', 'C2', 8],
            [414, 2024, 'A3', 'C3', 5],
            [420, 2024, 'A4', 'C4', 9],
            [446, 2024, 'K1', 'C4', 8],
            [424, 2024, 'A5', 'C3', 7],
            [452, 2024, 'K2', 'C5', 9],
            [445, 2024, 'K1', 'C3', 9],
            [396, 2024, 'A1', 'C5', 5],
            [455, 2024, 'K3', 'C3', 9],
            [451, 2024, 'K2', 'C4', 8],
            [411, 2024, 'A2', 'C5', 7],
            [412, 2024, 'A3', 'C1', 7],
            [454, 2024, 'K3', 'C2', 9],
            [405, 2024, 'A#', 'C4', -1],
            [419, 2024, 'A4', 'C3', 7],
            [395, 2024, 'A1', 'C4', 7],
            [423, 2024, 'A5', 'C2', 8],
            [409, 2024, 'A2', 'C3', 9],
            [410, 2024, 'A2', 'C4', 7],
            [444, 2024, 'K1', 'C2', 6],
            [404, 2024, 'A#', 'C3', -1],
            [450, 2024, 'K2', 'C3', 6],
            [418, 2024, 'A4', 'C2', 7],
            [394, 2024, 'A1', 'C3', 9],
            [449, 2024, 'K2', 'C2', 7],
            [422, 2024, 'A5', 'C1', 7],
            [407, 2024, 'A2', 'C1', 7],
            [408, 2024, 'A2', 'C2', 7],
            [443, 2024, 'K1', 'C1', 8],
            [403, 2024, 'A#', 'C2', -1],
            [448, 2024, 'K2', 'C1', 8],
            [417, 2024, 'A4', 'C1', 8],
            [392, 2024, 'A1', 'C1', 8],
            [393, 2024, 'A1', 'C2', 9],
            [572, 2025, 'BS', 'PU', 2],
            [571, 2025, 'BS', 'PG', 1],
            [570, 2025, 'BS', 'PA', 9],
            [569, 2025, 'AG', 'TT', 5],
            [568, 2025, 'AG', 'TI', 4],
            [567, 2025, 'AG', 'PU', 3],
            [566, 2025, 'AG', 'PG', 2],
            [565, 2025, 'AG', 'PA', 1],
            [579, 2025, 'RF', 'TT', 6],
            [578, 2025, 'RF', 'TI', 5],
            [577, 2025, 'RF', 'PU', 4],
            [576, 2025, 'RF', 'PG', 4],
            [575, 2025, 'RF', 'PA', 4],
            [574, 2025, 'BS', 'TT', 5],
            [573, 2025, 'BS', 'TI', 3],
        ];

        foreach ($data as $item) {

            DB::table('rel_alternatif')->insert([
                'rel_alternatif_id' => $item[0],
                'tahun' => $item[1],
                'kode_alternatif' => $item[2],
                'kode_kriteria' => $item[3],
                'nilai' => $item[4],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
