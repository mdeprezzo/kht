<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\Users\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $permissions = RolesEnum::permissions();

        foreach ($permissions as $role => $permissionsList) {
            foreach ($permissionsList as $permission) {
                Permission::firstOrCreate(['name' => $permission]);
            }
        }

        foreach (RolesEnum::cases() as $case) {
            $role = Role::firstOrCreate(['name' => $case->value]);

            foreach ($permissions[$case->value] as $permission) {
                $role->givePermissionTo($permission);
            }
        }

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@kht.com',
        ])->assignRole(RolesEnum::ADMIN->value);
    }
}
