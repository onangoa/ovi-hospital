<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ApplicationSetting extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\ApplicationSetting::create([
            'item_name' => 'OVI HMS',
            'item_short_name' => 'OVI HMS',
            'item_version' => '1.0',
            'company_name' => 'OVI Hospital',
            'company_email' => 'admin@gmail.com',
            'company_address' => 'Nairobi, Kenya',
            'developed_by' => 'kesmak',
            'developed_by_href' => 'http://kesmak.co.ke/',
            'developed_by_title' => 'Your hope our goal',
            'developed_by_prefix' => 'Developed by',
            'support_email' => 'admin@gmail.com',
            'language' => 'en',
            'is_demo' => '0',
            'time_zone' => 'Africa/Nairobi',
        ]);
    }
}
