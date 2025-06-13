<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear los roles si no existen
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $memberRole = Role::firstOrCreate(['name' => 'member']);

        // Crear usuarios
        $superAdmin = User::firstOrCreate([
            'email' => 'sadmin@qwe'
        ], [
            'name' => 'Super Administrador',
            'password' => bcrypt('123')
        ]);

        $admin = User::firstOrCreate([
            'email' => 'admin1@qwe'
        ], [
            'name' => 'Administrador',
            'password' => bcrypt('123')
        ]);

        $member = User::firstOrCreate([
            'email' => 'member2@qwe'
        ], [
            'name' => 'Miembro',
            'password' => bcrypt('123')
        ]);

        // Asignar roles
        $superAdmin->assignRole($superAdminRole);
        $admin->assignRole($adminRole);
        $member->assignRole($memberRole);

        // Obtener todos los permisos disponibles
        $allPermissions = Permission::all();

        // Asignar todos los permisos al rol super_admin
        $superAdminRole->syncPermissions($allPermissions);
    }
}
