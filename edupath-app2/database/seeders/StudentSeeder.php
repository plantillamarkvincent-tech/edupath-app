<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Example demo student linked to the admin user, if needed.
        // Adjust or extend this as you wish, or leave it empty.

        $user = User::where('email', 'admin@example.com')->first();

        if (! $user) {
            $user = User::create([
                'name' => 'System Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]);
        }

        Student::firstOrCreate([
            'user_id' => $user->id,
        ], [
            'student_number'   => 'DORSU-0001',
            'first_name'       => 'System',
            'middle_name'      => null,
            'last_name'        => 'Admin',
            'birthdate'        => null,
            'sex'              => null,
            'contact_number'   => null,
            'address'          => null,
            'program_id'       => null,
            'year_level'       => null,
            'status'           => 'active',
        ]);
    }
}
