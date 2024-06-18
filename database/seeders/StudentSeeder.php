<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::factory([
            'name' => 'student1',
            'email' => 'student1@test.com',
            'password' => Hash::make(1234),
            'is_admin' => false,
        ])->create();
        User::factory([
            'name' => 'student2',
            'email' => 'student2@test.com',
            'password' => Hash::make(1234),
            'is_admin' => false,
        ])->create();
    }
}
