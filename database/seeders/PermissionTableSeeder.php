<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::firstOrCreate([
            'name' => 'role-read',
            'display_name' => 'Role',
        ]);
        Permission::firstOrCreate([
            'name' => 'role-create',
            'display_name' => 'Role',
        ]);
        Permission::firstOrCreate([
            'name' => 'role-update',
            'display_name' => 'Role',
        ]);
        Permission::firstOrCreate([
            'name' => 'role-delete',
            'display_name' => 'Role',
        ]);

        Permission::firstOrCreate([
            'name' => 'user-read',
            'display_name' => 'User',
        ]);
        Permission::firstOrCreate([
            'name' => 'user-create',
            'display_name' => 'User',
        ]);
        Permission::firstOrCreate([
            'name' => 'user-update',
            'display_name' => 'User',
        ]);
        Permission::firstOrCreate([
            'name' => 'user-delete',
            'display_name' => 'User',
        ]);

        

        Permission::firstOrCreate([
            'name' => 'company-read',
            'display_name' => 'Company',
        ]);
        Permission::firstOrCreate([
            'name' => 'company-create',
            'display_name' => 'Company',
        ]);
        Permission::firstOrCreate([
            'name' => 'company-update',
            'display_name' => 'Company',
        ]);
        Permission::firstOrCreate([
            'name' => 'company-delete',
            'display_name' => 'Company',
        ]);

        Permission::firstOrCreate([
            'name' => 'currencies-read',
            'display_name' => 'Currencies',
        ]);
        Permission::firstOrCreate([
            'name' => 'currencies-create',
            'display_name' => 'Currencies',
        ]);
        Permission::firstOrCreate([
            'name' => 'currencies-update',
            'display_name' => 'Currencies',
        ]);
        Permission::firstOrCreate([
            'name' => 'currencies-delete',
            'display_name' => 'Currencies',
        ]);

        Permission::firstOrCreate([
            'name' => 'tax-rate-read',
            'display_name' => 'Tax Rate',
        ]);
        Permission::firstOrCreate([
            'name' => 'tax-rate-create',
            'display_name' => 'Tax Rate',
        ]);
        Permission::firstOrCreate([
            'name' => 'tax-rate-update',
            'display_name' => 'Tax Rate',
        ]);
        Permission::firstOrCreate([
            'name' => 'tax-rate-delete',
            'display_name' => 'Tax Rate',
        ]);

        Permission::firstOrCreate([
            'name' => 'profile-read',
            'display_name' => 'Profile',
        ]);
        Permission::firstOrCreate([
            'name' => 'profile-update',
            'display_name' => 'Profile',
        ]);

        Permission::firstOrCreate([
            'name' => 'hospital-department-read',
            'display_name' => 'Hospital Department'
        ]);
        Permission::firstOrCreate([
            'name' => 'hospital-department-create',
            'display_name' => 'Hospital Department'
        ]);
        Permission::firstOrCreate([
            'name' => 'hospital-department-update',
            'display_name' => 'Hospital Department'
        ]);
        Permission::firstOrCreate([
            'name' => 'hospital-department-delete',
            'display_name' => 'Hospital Department'
        ]);

        Permission::firstOrCreate([
            'name' => 'doctor-detail-read',
            'display_name' => 'Doctor Detail'
        ]);
        Permission::firstOrCreate([
            'name' => 'doctor-detail-create',
            'display_name' => 'Doctor Detail'
        ]);
        Permission::firstOrCreate([
            'name' => 'doctor-detail-update',
            'display_name' => 'Doctor Detail'
        ]);
        Permission::firstOrCreate([
            'name' => 'doctor-detail-delete',
            'display_name' => 'Doctor Detail'
        ]);
        Permission::firstOrCreate([
            'name' => 'patient-detail-read',
            'display_name' => 'Patient Detail',
        ]);
        Permission::firstOrCreate([
            'name' => 'patient-detail-create',
            'display_name' => 'Patient Detail',
        ]);
        Permission::firstOrCreate([
            'name' => 'patient-detail-update',
            'display_name' => 'Patient Detail',
        ]);
        Permission::firstOrCreate([
            'name' => 'patient-detail-delete',
            'display_name' => 'Patient Detail',
        ]);

        Permission::firstOrCreate([
            'name' => 'patient-case-studies-read',
            'display_name' => 'Patient Case Studies',
        ]);
        Permission::firstOrCreate([
            'name' => 'patient-case-studies-create',
            'display_name' => 'Patient Case Studies',
        ]);
        Permission::firstOrCreate([
            'name' => 'patient-case-studies-update',
            'display_name' => 'Patient Case Studies',
        ]);
        Permission::firstOrCreate([
            'name' => 'patient-case-studies-delete',
            'display_name' => 'Patient Case Studies',
        ]);

        

        Permission::firstOrCreate([
            'name' => 'lab-report-read',
            'display_name' => 'Lab Report',
        ]);

        Permission::firstOrCreate([
            'name' => 'lab-report-create',
            'display_name' => 'Lab Report',
        ]);

        Permission::firstOrCreate([
            'name' => 'lab-report-update',
            'display_name' => 'Lab Report',
        ]);

        Permission::firstOrCreate([
            'name' => 'lab-report-delete',
            'display_name' => 'Lab Report',
        ]);

        Permission::firstOrCreate([
            'name' => 'lab-report-template-read',
            'display_name' => 'Lab Report Template',
        ]);

        Permission::firstOrCreate([
            'name' => 'lab-report-template-create',
            'display_name' => 'Lab Report Template',
        ]);

        Permission::firstOrCreate([
            'name' => 'lab-report-template-update',
            'display_name' => 'Lab Report Template',
        ]);

        Permission::firstOrCreate([
            'name' => 'lab-report-template-delete',
            'display_name' => 'Lab Report Template',
        ]);

        

        Permission::firstOrCreate([
            'name' => 'patient-appointment-read',
            'display_name' => 'Patient Appointment'
        ]);
        Permission::firstOrCreate([
            'name' => 'patient-appointment-create',
            'display_name' => 'Patient Appointment'
        ]);
        Permission::firstOrCreate([
            'name' => 'patient-appointment-update',
            'display_name' => 'Patient Appointment'
        ]);
        Permission::firstOrCreate([
            'name' => 'patient-appointment-delete',
            'display_name' => 'Patient Appointment'
        ]);

        Permission::firstOrCreate([
            'name' => 'prescription-read',
            'display_name' => 'Prescription',
        ]);
        Permission::firstOrCreate([
            'name' => 'prescription-create',
            'display_name' => 'Prescription',
        ]);
        Permission::firstOrCreate([
            'name' => 'prescription-update',
            'display_name' => 'Prescription',
        ]);
        Permission::firstOrCreate([
            'name' => 'prescription-delete',
            'display_name' => 'Prescription',
        ]);

        
        // Clinical Module Permissions
        Permission::firstOrCreate(['name' => 'cvi-read', 'display_name' => 'Child Vitality Index']);
        Permission::firstOrCreate(['name' => 'cvi-create', 'display_name' => 'Child Vitality Index']);
        Permission::firstOrCreate(['name' => 'cvi-update', 'display_name' => 'Child Vitality Index']);
        Permission::firstOrCreate(['name' => 'cvi-delete', 'display_name' => 'Child Vitality Index']);

        Permission::firstOrCreate(['name' => 'initial-evaluations-read', 'display_name' => 'Initial Evaluation']);
        Permission::firstOrCreate(['name' => 'initial-evaluations-create', 'display_name' => 'Initial Evaluation']);
        Permission::firstOrCreate(['name' => 'initial-evaluations-update', 'display_name' => 'Initial Evaluation']);
        Permission::firstOrCreate(['name' => 'initial-evaluations-delete', 'display_name' => 'Initial Evaluation']);

        Permission::firstOrCreate(['name' => 'care-plans-read', 'display_name' => 'Care Plan']);
        Permission::firstOrCreate(['name' => 'care-plans-create', 'display_name' => 'Care Plan']);
        Permission::firstOrCreate(['name' => 'care-plans-update', 'display_name' => 'Care Plan']);
        Permission::firstOrCreate(['name' => 'care-plans-delete', 'display_name' => 'Care Plan']);

        Permission::firstOrCreate(['name' => 'lab-requests-read', 'display_name' => 'Lab Request']);
        Permission::firstOrCreate(['name' => 'lab-requests-create', 'display_name' => 'Lab Request']);
        Permission::firstOrCreate(['name' => 'lab-requests-update', 'display_name' => 'Lab Request']);
        Permission::firstOrCreate(['name' => 'lab-requests-delete', 'display_name' => 'Lab Request']);

        Permission::firstOrCreate(['name' => 'ward-round-notes-read', 'display_name' => 'Ward Round Notes']);
        Permission::firstOrCreate(['name' => 'ward-round-notes-create', 'display_name' => 'Ward Round Notes']);
        Permission::firstOrCreate(['name' => 'ward-round-notes-update', 'display_name' => 'Ward Round Notes']);
        Permission::firstOrCreate(['name' => 'ward-round-notes-delete', 'display_name' => 'Ward Round Notes']);

        Permission::firstOrCreate(['name' => 'caregiver-daily-reports-read', 'display_name' => 'Caregiver Daily Report']);
        Permission::firstOrCreate(['name' => 'caregiver-daily-reports-create', 'display_name' => 'Caregiver Daily Report']);
        Permission::firstOrCreate(['name' => 'caregiver-daily-reports-update', 'display_name' => 'Caregiver Daily Report']);
        Permission::firstOrCreate(['name' => 'caregiver-daily-reports-delete', 'display_name' => 'Caregiver Daily Report']);

        Permission::firstOrCreate(['name' => 'therapy-reports-read', 'display_name' => 'Therapy Report']);
        Permission::firstOrCreate(['name' => 'therapy-reports-create', 'display_name' => 'Therapy Report']);
        Permission::firstOrCreate(['name' => 'therapy-reports-update', 'display_name' => 'Therapy Report']);
        Permission::firstOrCreate(['name' => 'therapy-reports-delete', 'display_name' => 'Therapy Report']);

        Permission::firstOrCreate(['name' => 'weekly-wellness-checks-read', 'display_name' => 'Weekly Wellness Check']);
        Permission::firstOrCreate(['name' => 'weekly-wellness-checks-create', 'display_name' => 'Weekly Wellness Check']);
        Permission::firstOrCreate(['name' => 'weekly-wellness-checks-update', 'display_name' => 'Weekly Wellness Check']);
        Permission::firstOrCreate(['name' => 'weekly-wellness-checks-delete', 'display_name' => 'Weekly Wellness Check']);
        
        // Ward Module Permissions
        Permission::firstOrCreate(['name' => 'ward-read', 'display_name' => 'Ward']);
        Permission::firstOrCreate(['name' => 'ward-create', 'display_name' => 'Ward']);
        Permission::firstOrCreate(['name' => 'ward-update', 'display_name' => 'Ward']);
        Permission::firstOrCreate(['name' => 'ward-delete', 'display_name' => 'Ward']);

        // New Module Permissions are now handled by NewPermissionsSeeder
        
        // Vital Signs Management Permissions
        Permission::firstOrCreate(['name' => 'vital-signs-read', 'display_name' => 'Vital Signs Configuration']);
        Permission::firstOrCreate(['name' => 'vital-signs-create', 'display_name' => 'Vital Signs Configuration']);
        Permission::firstOrCreate(['name' => 'vital-signs-update', 'display_name' => 'Vital Signs Configuration']);
        Permission::firstOrCreate(['name' => 'vital-signs-delete', 'display_name' => 'Vital Signs Configuration']);
    }
}
