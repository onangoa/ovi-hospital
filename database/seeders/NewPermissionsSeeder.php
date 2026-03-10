<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class NewPermissionsSeeder extends Seeder
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
                'name' => 'medical-referrals-read',
                'display_name' => 'Medical Referrals'
            ],
            [
                'name' => 'medical-referrals-create',
                'display_name' => 'Medical Referrals'
            ],
            [
                'name' => 'medical-referrals-update',
                'display_name' => 'Medical Referrals'
            ],
            [
                'name' => 'medical-referrals-delete',
                'display_name' => 'Medical Referrals'
            ],
            [
                'name' => 'radiology-requests-read',
                'display_name' => 'Radiology Requests'
            ],
            [
                'name' => 'radiology-requests-create',
                'display_name' => 'Radiology Requests'
            ],
            [
                'name' => 'radiology-requests-update',
                'display_name' => 'Radiology Requests'
            ],
            [
                'name' => 'radiology-requests-delete',
                'display_name' => 'Radiology Requests'
            ],
            [
                'name' => 'drug-orders-read',
                'display_name' => 'Drug Orders'
            ],
            [
                'name' => 'drug-orders-create',
                'display_name' => 'Drug Orders'
            ],
            [
                'name' => 'drug-orders-update',
                'display_name' => 'Drug Orders'
            ],
            [
                'name' => 'drug-orders-delete',
                'display_name' => 'Drug Orders'
            ],
            [
                'name' => 'nursing-cardexes-read',
                'display_name' => 'Nursing Cardexes'
            ],
            [
                'name' => 'nursing-cardexes-create',
                'display_name' => 'Nursing Cardexes'
            ],
            [
                'name' => 'nursing-cardexes-update',
                'display_name' => 'Nursing Cardexes'
            ],
            [
                'name' => 'nursing-cardexes-delete',
                'display_name' => 'Nursing Cardexes'
            ],
            [
                'name' => 'clinical-leaderboard-read',
                'display_name' => 'Clinical Leaderboard'
            ],
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

        // Assign permissions to Super Admin role
        $superAdminRole = Role::where('name', 'Super Admin')->first();
        if ($superAdminRole) {
            $superAdminRole->givePermissionTo(Permission::whereIn('name', array_column($permissions, 'name'))->pluck('id'));
        }

        // Note: Admin role might not exist, so we'll check before assigning permissions
        $adminRole = Role::where('name', 'Admin')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo(Permission::whereIn('name', array_column($permissions, 'name'))->pluck('id'));
        }
    }
}
