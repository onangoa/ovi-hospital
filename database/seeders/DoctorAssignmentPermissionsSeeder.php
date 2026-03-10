<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DoctorAssignmentPermissionsSeeder extends Seeder
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
                'name' => 'doctor-assignment-read',
                'display_name' => 'Doctor Assignments'
            ],
            [
                'name' => 'doctor-assignment-create',
                'display_name' => 'Doctor Assignments'
            ],
            [
                'name' => 'doctor-assignment-update',
                'display_name' => 'Doctor Assignments'
            ],
            [
                'name' => 'doctor-assignment-delete',
                'display_name' => 'Doctor Assignments'
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission['name'],
                'display_name' => $permission['display_name'],
            ]);
        }

        // Note: Admin role might not exist, so we'll check before assigning permissions
        $adminRole = Role::where('name', 'Admin')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo(Permission::whereIn('name', array_column($permissions, 'name'))->pluck('id'));
        }
    }
}