<?php

namespace Database\Seeders;

use App\Models\PertanyaanKeamanan;
use App\Models\UserDosenTendik;
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
        $pertanyaanPanggilan = PertanyaanKeamanan::query()->where('id', 2)->first();
        $pertanyaanMakanan = PertanyaanKeamanan::query()->where('id', 7)->first();

        $admin1 = UserDosenTendik::query()->firstOrCreate(
                [
                    'email' => 'bertha@tsu.ac.id',
                ],
                [
                    'username' => '202025119',
                    'name' => 'Bertha Pratama Adhita Putra, S.Kom',
                    'password' => Hash::make('Nerro600'),
                    'unit' => 'Pusar Informasi, Komunikasi, dan Digital',
                    'q1' => $pertanyaanPanggilan?->id,
                    'a1' => 'bertha',
                    'q2' => $pertanyaanMakanan?->id,
                    'a2' => 'magelangan',
                    'created_by' => '202025119',
                ]);

        $admin2 = UserDosenTendik::query()->firstOrCreate(
                [
                    'email' => 'ancasea@tsu.ac.id',
                ],
                [
                    'username' => '202025109',
                    'name' => 'Ancase Rekasae Suryo Dwi Raharjo, S.Kom',
                    'password' => Hash::make('ancas@241'),
                    'unit' => 'Pusar Informasi, Komunikasi, dan Digital',
                    'q1' => $pertanyaanPanggilan?->id,
                    'a1' => 'ancasea',
                    'q2' => $pertanyaanMakanan?->id,
                    'a2' => 'endog',
                    'created_by' => '202025109',
                ]);

        $admin3 = UserDosenTendik::firstOrCreate(
                [
                    'email' => 'bramasto@tsu.ac.id',
                ],
                [
                    'username' => '623048003',
                    'nidn' => '0623048003',
                    'name' => 'Bramasto Wiryawan Yudanto, S.T.,M.MSI.',
                    'password' => Hash::make('bramasto@123#'),
                    'unit' => 'Pusar Informasi, Komunikasi, dan Digital',
                    'q1' => $pertanyaanPanggilan?->id,
                    'a1' => 'bramasto',
                    'q2' => $pertanyaanMakanan?->id,
                    'a2' => 'nasi goreng',
                    'created_by' => '623048003',
                ]);

        // Berikan role 'admin' ke user tersebut
        $superAdminRole = Role::query()->where('name', 'super admin')->first();
        $adminRole = Role::query()->where('name', 'admin')->first();

        if ($superAdminRole && $adminRole) {
            $admin1->assignRole($adminRole);
            $admin2->assignRole($superAdminRole);
            $admin3->assignRole($adminRole);
        }
    }
}
