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
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions

        $permissions = [
            'view animals',
            'create animals',
            'edit animals',
            'delete animals',
            'manage farm',
            'view investments',
            'make investments',
            'view marketplace',
            // 'trade shares',
            'manage users',
            'view reports',
            // 'manage dividends',
            'manage transactions',
            'approve kyc',
            'manage farms',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $farmOwnerRole = Role::create(['name' => 'farm_owner']);
        $farmOwnerRole->givePermissionTo([
            'view animals', 'create animals', 'edit animals', 'manage farm',
            'view reports',
        ]);

        $farmManagerRole = Role::create(['name' => 'farm_manager']);
        $farmManagerRole->givePermissionTo([
            'view animals', 'edit animals', 'manage farm'
        ]);

        $investorRole = Role::create(['name' => 'investor']);
        $investorRole->givePermissionTo([
            'view animals', 'view investments', 'make investments',
            'view marketplace', 'trade shares'
        ]);

        $veterinarianRole = Role::create(['name' => 'veterinarian']);
        $veterinarianRole->givePermissionTo([
            'view animals', 'edit animals'
        ]);

    }
}
