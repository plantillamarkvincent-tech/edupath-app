<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Test Admin',
            'email' => 'test@admin.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        echo "Admin user created!\n";
        echo "Email: test@admin.com\n";
        echo "Password: password123\n";
    }
}
