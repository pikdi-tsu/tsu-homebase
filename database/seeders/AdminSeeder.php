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
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $pertanyaanPanggilan = PertanyaanKeamanan::where('id', 2)->first();
        $pertanyaanMakanan = PertanyaanKeamanan::where('id', 7)->first();

        $admin1 = UserDosenTendik::firstOrCreate(
                [
                    'email' => 'bertha@tsu.ac.id',
                ],
                [
                    'nik' => '111111111111',
                    'name' => 'Bertha',
                    'password' => Hash::make('Nerro600'),
                    'q1' => $pertanyaanPanggilan->id,
                    'a1' => 'bertha',
                    'q2' => $pertanyaanMakanan->id,
                    'a2' => 'magelangan',
                    'created_by' => '111111111111',
                ]);

        $admin2 = UserDosenTendik::firstOrCreate(
                [
                    'email' => 'ancase@tsu.ac.id',
                ],
                [
                    'nik' => '222222222222',
                    'name' => 'Ancase',
                    'password' => Hash::make('ancas@241'),
                    'q1' => $pertanyaanPanggilan->id,
                    'a1' => 'ancasea',
                    'q2' => $pertanyaanMakanan->id,
                    'a2' => 'endog',
                    'created_by' => '222222222222',
                ]);

        $admin3 = UserDosenTendik::firstOrCreate(
                [
                    'email' => 'bramasto@tsu.ac.id',
                ],
                [
                    'nik' => '333333333333',
                    'name' => 'Bramasto',
                    'password' => Hash::make('bramasto@123#'),
                    'q1' => $pertanyaanPanggilan->id,
                    'a1' => 'bramasto',
                    'q2' => $pertanyaanMakanan->id,
                    'a2' => 'nasi goreng',
                    'created_by' => '333333333333',
                ]);

        // Berikan role 'admin' ke user tersebut
        $admin1->assignRole($adminRole);
        $admin2->assignRole($adminRole);
        $admin3->assignRole($adminRole);
    }
}
