<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan cache permission agar data baru terbaca
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Permission
        $permissions = [
            'lihat buku',
            'tambah buku',
            'edit buku',
            'hapus buku',
            'kelola role',
        ];
        foreach ($permissions as $p) {
            Permission::firstOrCreate(['name' => $p]);
        }

        // 2. Role
        $admin     = Role::firstOrCreate(['name' => 'Admin']);
        $dosen     = Role::firstOrCreate(['name' => 'Dosen']);
        $mahasiswa = Role::firstOrCreate(['name' => 'Mahasiswa']);

        // 3. Hubungkan role dengan permission
        $admin->syncPermissions(Permission::all());
        $dosen->syncPermissions(['lihat buku', 'tambah buku', 'edit buku']);
        $mahasiswa->syncPermissions(['lihat buku']);

        // 4. Akun uji untuk tiap role
        $akun = [
            ['Admin Uji',     'admin@test.com',     'Admin'],
            ['Dosen Uji',     'dosen@test.com',     'Dosen'],
            ['Mahasiswa Uji', 'mahasiswa@test.com', 'Mahasiswa'],
        ];
        foreach ($akun as [$nama, $email, $role]) {
            $user = User::firstOrCreate(
                ['email' => $email],
                ['name' => $nama, 'password' => Hash::make('password')]
            );
            $user->syncRoles($role);
        }
    }
}