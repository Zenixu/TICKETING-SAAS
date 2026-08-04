<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@tiketkita.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('Admin123!@#'),
                'role' => 'admin',
                'organizer_status' => 'approved',
            ]
        );
    }
}
