<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions untuk Homebase Core
        Permission::create(['name' => 'homebase:oauth-client:manage', 'guard_name' => 'web']);
        Permission::create(['name' => 'homebase:permission:manage', 'guard_name' => 'web']);
        Permission::create(['name' => 'homebase:role:manage', 'guard_name' => 'web']);
        Permission::create(['name' => 'homebase:pertanyaan-keamanan:manage', 'guard_name' => 'web']);
        Permission::create(['name' => 'homebase:user-dosen-tendik:view-any', 'guard_name' => 'web']);
        Permission::create(['name' => 'homebase:user-dosen-tendik:create', 'guard_name' => 'web']);
        Permission::create(['name' => 'homebase:user-dosen-tendik:update', 'guard_name' => 'web']);
        Permission::create(['name' => 'homebase:user-dosen-tendik:delete', 'guard_name' => 'web']);
        Permission::create(['name' => 'homebase:user-mahasiswa:view-any', 'guard_name' => 'web']);
        Permission::create(['name' => 'homebase:user-mahasiswa:create', 'guard_name' => 'web']);
        Permission::create(['name' => 'homebase:user-mahasiswa:update', 'guard_name' => 'web']);
        Permission::create(['name' => 'homebase:user-mahasiswa:delete', 'guard_name' => 'web']);
//        Permission::create(['name' => 'homebase:user-mahasiswa:view-any', 'guard_name' => 'api2']);
//        Permission::create(['name' => 'homebase:user-mahasiswa:create', 'guard_name' => 'api2']);
//        Permission::create(['name' => 'homebase:user-mahasiswa:update', 'guard_name' => 'api2']);
//        Permission::create(['name' => 'homebase:user-mahasiswa:delete', 'guard_name' => 'api2']);

//        // Permissions untuk modul Akademik (contoh masa depan)
//        Permission::create(['name' => 'pmb:jadwal:view']);
//        Permission::create(['name' => 'pmb:nilai:input']);

        // Buat Role Admin dan berikan semua permission
        $adminRole = Role::query()->where('name', 'admin')->first();
        $adminRole->givePermissionTo(Permission::all());

//        // Buat Role Dosen
//        $dosenRole = Role::query()->where('name', 'dosen')->first();
//        $dosenRole->givePermissionTo([
//            'pmb:user:view-any',
//        ]);
//
//        // Buat Role Mahasiswa
//        $mahasiswaRole = Role::query()->where('name', 'mahasiswa')->first();
//        $mahasiswaRole->givePermissionTo('akademik:jadwal:view');
    }
}
