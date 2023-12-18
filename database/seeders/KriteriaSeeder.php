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
            ['kode_kriteria' => 'C2', 'tahun' => 2024, 'nama_kriteria' => 'Skill', 'atribut' => 'benefit'],
            ['kode_kriteria' => 'C3', 'tahun' => 2024, 'nama_kriteria' => 'Komunikasi', 'atribut' => 'benefit'],
            ['kode_kriteria' => 'C4', 'tahun' => 2024, 'nama_kriteria' => 'Masa Kerja', 'atribut' => 'cost'],
            ['kode_kriteria' => 'C5', 'tahun' => 2024, 'nama_kriteria' => 'Pengalaman', 'atribut' => 'benefit'],
            ['kode_kriteria' => 'C1', 'tahun' => 2024, 'nama_kriteria' => 'Pendidikan', 'atribut' => 'benefit'],
            ['kode_kriteria' => 'TT', 'tahun' => 2025, 'nama_kriteria' => 'TTTT', 'atribut' => 'benefit'],
            ['kode_kriteria' => 'TI', 'tahun' => 2025, 'nama_kriteria' => 'TITI', 'atribut' => 'benefit'],
            ['kode_kriteria' => 'PA', 'tahun' => 2025, 'nama_kriteria' => 'PAPA', 'atribut' => 'benefit'],
            ['kode_kriteria' => 'PU', 'tahun' => 2025, 'nama_kriteria' => 'PU pu', 'atribut' => 'benefit'],
            ['kode_kriteria' => 'PG', 'tahun' => 2025, 'nama_kriteria' => 'PGPG', 'atribut' => 'benefit'],
        ];

        foreach ($data as $item) {
            DB::table('kriteria')->insert($item);
        }
    }
}