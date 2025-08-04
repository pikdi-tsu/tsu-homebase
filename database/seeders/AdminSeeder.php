<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat role 'admin' jika belum ada
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Buat user super admin jika belum ada
        $superAdmin = User::firstOrCreate([
                'name' => 'Super Admin',
                'email' => 'superadmin@tsu.ac.id', // Email untuk login
                'password' => Hash::make('superadmin'), // Ganti dengan password yang aman
            ]);

        $admin = User::firstOrCreate([
                'name' => 'Admin',
                'email' => 'admin@tsu.ac.id', // Email untuk login
                'password' => Hash::make('admin123'), // Ganti dengan password yang aman
            ]);

        // Berikan role 'admin' ke user tersebut
        $superAdmin->assignRole($superAdminRole);
        $admin->assignRole($adminRole);
    }
}
