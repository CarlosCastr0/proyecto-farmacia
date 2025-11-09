<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@farmacia.test'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );

        if (($admin->role ?? 'user') !== 'admin') {
            $admin->role = 'admin';
            $admin->save();
        }
    }
}

