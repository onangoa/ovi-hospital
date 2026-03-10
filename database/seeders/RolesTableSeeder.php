<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create([
            'name' => 'Super Admin',
            'guard_name' => 'web',
            'is_default' => '1',
            'role_for' => '0',
        ]);
        $permissions = Permission::select('id')->get()->pluck('id');
        $role->syncPermissions($permissions);

        $doctor = Role::create([
            'name' => 'Doctor',
            'guard_name' => 'web',
            'role_for' => '1',
            'is_default' => '1',
        ]);
        $doctorPermissions = Permission::select('id')
            ->orWhere('name', 'like', 'patient-case-studies-%')
            ->orWhere('name', 'lab-report-read')
            ->orWhere('name', 'patient-appointment-read')
            ->orWhere('name', 'like', 'prescription-%')
            ->get()->pluck('id');
        $doctor->syncPermissions($doctorPermissions);

        $patient = Role::create([
            'name' => 'Patient',
            'guard_name' => 'web',
            'role_for' => '1',
            'is_default' => '1',
        ]);
        $patientPermissions = Permission::select('id')
            ->where('name', 'doctor-detail-read')
            ->orWhere('name', 'patient-detail-read')
            ->orWhere('name', 'patient-case-studies-read')
            ->orWhere('name', 'insurance-read')
            ->orWhere('name', 'lab-report-read')
            ->orWhere('name', 'patient-appointment-read')
            ->orWhere('name', 'prescription-read')
            ->orWhere('name', 'invoice-read')
            ->get()->pluck('id');
        $patient->syncPermissions($patientPermissions);

        // Create Clinical Leader role
        $clinicalLeaderRole = Role::create([
            'name' => 'Clinical Leader',
            'guard_name' => 'web',
            'role_for' => '1',
            'is_default' => '0',
        ]);
        $clinicalLeaderPermissions = Permission::select('id')
            ->orWhere('name', 'like', 'medical-referrals-%')
            ->orWhere('name', 'like', 'radiology-requests-%')
            ->orWhere('name', 'like', 'drug-orders-%')
            ->orWhere('name', 'like', 'nursing-cardexes-%')
            ->orWhere('name', 'clinical-leaderboard-read')
            ->orWhere('name', 'like', 'therapy-reports-%')
            ->orWhere('name', 'like', 'initial-evaluations-%')
            ->orWhere('name', 'like', 'care-plans-%')
            ->orWhere('name', 'like', 'lab-requests-%')
            ->orWhere('name', 'like', 'ward-round-notes-%')
            ->orWhere('name', 'like', 'caregiver-daily-reports-%')
            ->orWhere('name', 'like', 'weekly-wellness-checks-%')
            ->get()->pluck('id');
        $clinicalLeaderRole->syncPermissions($clinicalLeaderPermissions);

        $adminRole = Role::findByName('Super Admin');
        $adminRole->givePermissionTo(Permission::all());
    }
}
