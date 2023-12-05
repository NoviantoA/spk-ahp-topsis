<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class AlternatifSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [1, 2024, 'Pigus Haryanto', '', 0.44498241554123, 6],
            [2, 2024, 'Mubasyir Mustafa', '', 0.55562479920148, 3],
            [3, 2024, 'Gunawan', '', 0.43636841215278, 7],
            [4, 2024, 'Apriyanto Pamungkas', 'a', 0.50399837453274, 4],
            [5, 2024, 'Nopi Pratomo', 'b', 0.45788663123249, 5],
            [6, 2024, 'Asep Kurnia', 'a', 0.87814961732074, 2],
            [7, 2024, 'Gunawansyah', '', 0.39301552100718, 8],
            [8, 2024, 'Teguh', '', 0.89217894354515, 1],
            [9, 2025, 'Agus Suheri', 'Kepala Sekolah', 0.16416964352516, 3],
            [10, 2025, 'Bambang Sugiarto', 'Dosen', 0.65525791453524, 1],
            ['RF', 2025, 'Riffa Haviani Laluma', 'Staff', 0.50829346072274, 2],
        ];

        foreach ($data as $item) {
            DB::table('alternatif')->insert([
                'tahun' => $item[1],
                'nama_alternatif' => $item[2],
                'jabatan' => $item[3],
                'total' => $item[4],
                'rank' => $item[5],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
