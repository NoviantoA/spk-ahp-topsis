<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userRecords = [
            [
                'user_id' => 1,
                'role_id' => 1,
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('12345'),
                'photo' => 'admin.jpg',
                'address' => 'Tambakboyo',
                'phone' => '08921976923',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];
        User::insert($userRecords);
    }
}