<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Buat beberapa role jika belum ada
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            ['description' => 'Admin role',]
        );
        $userRole = Role::firstOrCreate(
            ['name' => 'user'],
            ['description' => 'User role',]
        );

        // Buat user baru
        $admin = User::create([
            'name' => 'Super admin',
            'username' => 'super_admin',
            'email' => 'super_admin@example.com',
            'password' => Hash::make('password'),
        ]);

        $user = User::create([
            'name' => 'Regular User',
            'username' => 'user',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
        ]);

        // Hubungkan user dengan role
        $admin->roles()->attach($adminRole);
        $user->roles()->attach($userRole);
    }
}