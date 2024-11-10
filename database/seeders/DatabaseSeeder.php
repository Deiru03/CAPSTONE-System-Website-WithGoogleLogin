<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Campus;
use App\Models\Department;
use App\Models\Program;
use App\Models\AdminId;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'F Super-Admin',
            'email' => 'omsc.iqaclearvault@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('OMSCIQA#2024'),
            'user_type' => 'Admin',
        ]);

        Campus::create([
            'name' => 'Testing Campus',    
        ]);

        Department::create([
            'name' => 'Testing Department',
            'campus_id' => 1,
        ]);

        Program::create([
            'name' => 'Testing Program',
            'department_id' => 1,
        ]);

        AdminId::create([
            'admin_id' => '12345',
        ]);
    }
}
