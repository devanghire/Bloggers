<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('Admin@123'),
            ],
            [
                'name' => 'Devang',
                'email' => 'devang@example.com',
                'password' => Hash::make('Devang@123'),
            ],
            [
                'name' => 'Asif',
                'email' => 'asif@example.com',
                'password' => Hash::make('Asif@123'),
            ],
        ]);
    }
}
