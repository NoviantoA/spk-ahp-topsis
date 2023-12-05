<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AlternatifSeeder::class);
        $this->call(KriteriaSeeder::class);
        $this->call(PeriodeSeeder::class);
        $this->call(RelAlternatifSeeder::class);
        $this->call(RelKriteriaSeeder::class);
    }
}