<?php

namespace Database\Seeders;

use App\Models\RoleModel;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rolesRecords = [
            [
              'role_id' => 1,
              'name' => 'Admin',
              'created_at' => Carbon::now(),
              'updated_at' => Carbon::now()
            ]
        ];
        RoleModel::insert($rolesRecords);
    }
}