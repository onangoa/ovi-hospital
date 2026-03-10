<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VitalSignsAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            \Database\Seeders\VitalSignSeeder::class,
            \Database\Seeders\PermissionTableSeeder::class,
        ]);
    }
}