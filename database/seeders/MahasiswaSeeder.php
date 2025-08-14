<?php

namespace Database\Seeders;

use App\Models\UserMahasiswa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin1 = UserMahasiswa::firstOrCreate(
                [
                    'email' => 'mahasiswa1@tsu.ac.id',
                ],
                [
                'nim' => '25100001',
                'name' => 'Mahasiswa1',
                'password' => Hash::make('mahasiswa1@123'),
                'created_by' => '25100001',
            ]);
    }
}
