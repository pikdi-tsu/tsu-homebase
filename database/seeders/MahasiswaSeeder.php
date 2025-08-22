<?php

namespace Database\Seeders;

use App\Models\UserMahasiswa;
use App\Services\DefaultPasswordService;
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
                    'email' => 'ivanbadai@tsu.ac.id',
                ],
                [
                'nim' => '25100001',
                'name' => 'Ivan Badai Muhammad',
                'password' => resolve(DefaultPasswordService::class)->getDefaultHashedPassword(),
                'created_by' => '202025109',
            ]);
    }
}
