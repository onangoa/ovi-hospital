<?php

namespace Database\Seeders;

use App\Models\DoctorDetail;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class CreateInitialUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456!'),
            'phone' => '0700000000',
            'address' => 'Nairobi, Kenya',
            'status' => '1',
        ]);
        $admin->companies()->attach(1);
        $adminRole = Role::where('name', 'Super Admin')->first();
        $admin->assignRole([$adminRole->id]);

        // $doctor = User::create([
        //     'company_id' => 1,
        //     'name' => 'Demo Doc',
        //     'email' => 'doctor@gmail.com',
        //     'password' => bcrypt('12345678'),
        //     'phone' => '0700000000',
        //     'address' => 'Nairobi, Kenya',
        //     'status' => '1',
        // ]);
        // $doctor->companies()->attach(1);
        // //$doctorRole = Role::where('name', 'Doctor')->first();
        // //$doctor->assignRole([$doctorRole->id]);

        // $patient = User::create([
        //     'company_id' => 1,
        //     'name' => 'John Doe',
        //     'email' => 'john@gmail.com',
        //     'password' => bcrypt('12345678'),
        //     'phone' => '0700000000',
        //     'address' => 'Nairobi, Kenya',
        //     'status' => '1',
        // ]);
        // $patient->companies()->attach(1);
        // $patientRole = Role::where('name', 'Patient')->first();
        // $patient->assignRole([$patientRole->id]);

        // $patient = User::create([
        //     'company_id' => 1,
        //     'name' => 'Jane Doe',
        //     'email' => 'jane@gmail.com',
        //     'password' => bcrypt('12345678'),
        //     'phone' => '0700000000',
        //     'address' => 'Nairobi, Kenya',
        //     'status' => '1',
        // ]);
        // $patient->companies()->attach(1);
        // $patientRole = Role::where('name', 'Patient')->first();
        // $patient->assignRole([$patientRole->id]);

        // $accountant = User::create([
        //     'company_id' => 1,
        //     'name' => 'Mr Accountant',
        //     'email' => 'accountant@gmail.com',
        //     'password' => bcrypt('12345678'),
        //     'phone' => '0700000000',
        //     'address' => 'Nairobi, Kenya',
        //     'status' => '1',
        // ]);
        // $accountant->companies()->attach(1);
        // $accountantRole = Role::where('name', 'Accountant')->first();
        // $accountant->assignRole([$accountantRole->id]);

        // $laboratorist = User::create([
        //     'company_id' => 1,
        //     'name' => 'Mr Laboratorist',
        //     'email' => 'laboratorist@gmail.com',
        //     'password' => bcrypt('12345678'),
        //     'phone' => '0700000000',
        //     'address' => 'Nairobi, Kenya',
        //     'status' => '1',
        // ]);
        // $laboratorist->companies()->attach(1);
        // $laboratoristRole = Role::where('name', 'Laboratorist')->first();
        // $laboratorist->assignRole([$laboratoristRole->id]);

        // $receptionist = User::create([
        //     'company_id' => 1,
        //     'name' => 'Mr Receptionist',
        //     'email' => 'receptionist@gmail.com',
        //     'password' => bcrypt('12345678'),
        //     'phone' => '0700000000',
        //     'address' => 'Nairobi, Kenya',
        //     'status' => '1',
        // ]);
        // $receptionist->companies()->attach(1);
        // $receptionistRole = Role::where('name', 'Receptionist')->first();
        // $receptionist->assignRole([$receptionistRole->id]);
    }
}
