<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ShiftPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'shift-read',
                'display_name' => 'Shift Read'
            ],
            [
                'name' => 'shift-create',
                'display_name' => 'Shift Create'
            ],
            [
                'name' => 'shift-update',
                'display_name' => 'Shift Update'
            ],
            [
                'name' => 'shift-delete',
                'display_name' => 'Shift Delete'
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission['name'],
                'display_name' => $permission['display_name'],
            ]);
        }

        // Assign permissions to Admin role
        $adminRole = Role::where('name', 'Super Admin')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo(Permission::whereIn('name', array_column($permissions, 'name'))->pluck('id'));
        }
    }
}
