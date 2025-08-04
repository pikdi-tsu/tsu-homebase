<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat role 'admin' jika belum ada
        $adminRole = Role::firstOrCreate(['name' => 'super admin']);

        // Buat user super admin jika belum ada
        $superAdmin = User::firstOrCreate([
                'name' => 'Super Admin',
                'email' => 'superadmin@tsu.ac.id', // Email untuk login
                'password' => Hash::make('superadmin'), // Ganti dengan password yang aman
            ]);

        // Berikan role 'admin' ke user tersebut
        $superAdmin->assignRole($adminRole);
    }
}
