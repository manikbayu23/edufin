<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Account;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            User::create([
                'name' => 'Admin Edufin',
                'email' => 'admin@example.com',
                'password' => Hash::make('12345678'), // Bcrypt hashing
                'role' => 'admin',
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
