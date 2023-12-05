<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['kriteria_id' => 1, 'tahun' => 2024, 'kriteria' => 'Skill', 'atribut' => 'benefit'],
            ['kriteria_id' => 2, 'tahun' => 2024, 'kriteria' => 'Komunikasi', 'atribut' => 'benefit'],
            ['kriteria_id' => 3, 'tahun' => 2024, 'kriteria' => 'Masa Kerja', 'atribut' => 'cost'],
            ['kriteria_id' => 4, 'tahun' => 2024, 'kriteria' => 'Pengalaman', 'atribut' => 'benefit'],
            ['kriteria_id' => 5, 'tahun' => 2024, 'kriteria' => 'Pendidikan', 'atribut' => 'benefit'],
            ['kriteria_id' => 6, 'tahun' => 2025, 'kriteria' => 'TTTT', 'atribut' => 'benefit'],
            ['kriteria_id' => 7, 'tahun' => 2025, 'kriteria' => 'TITI', 'atribut' => 'benefit'],
            ['kriteria_id' => 8, 'tahun' => 2025, 'kriteria' => 'PAPA', 'atribut' => 'benefit'],
            ['kriteria_id' => 9, 'tahun' => 2025, 'kriteria' => 'PU pu', 'atribut' => 'benefit'],
            ['kriteria_id' => 10, 'tahun' => 2025, 'kriteria' => 'PGPG', 'atribut' => 'benefit'],
        ];

        foreach ($data as $item) {
            DB::table('kriteria')->insert($item);
        }
    }
}