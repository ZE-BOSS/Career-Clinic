<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\admin_cc;
use Hash;

class AdlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        admin_cc::create([
	        'first_name'     => 'Obi',
            'middle_name'     => 'Christopher',
            'last_name'     => 'ikechukwu',
	        'Phone_1'     => '+2348105892905',
	        'user_name' => 'Zeboss',
	        'country' => 'Nigeria',
	        'state' => 'Lagos',
	        'email'    => 'ikchristo19@gmail.com',
	        'password' => Hash::make('SAVAGEjasper@12345'),
	        'user_type'     => 'Super Admin',
            'account_type'     => 'Alpha',
	        'remember_token' => rand(11111, 99999),
	    ]);

        admin_cc::create([
	        'first_name'     => 'Savage',
            'middle_name'     => 'Jasper',
            'last_name'     => 'Might',
	        'Phone_1'     => '+2348153669855',
	        'user_name' => 'sjasper',
	        'country' => 'Nigeria',
	        'state' => 'Lagos',
	        'email'    => 'savageelicite@gmail.com',
	        'password' => Hash::make('SAVAGEjasper@12345'),
	        'user_type'     => 'Admin',
            'account_type'     => 'Beta',
	        'remember_token' => rand(11111, 99999),
	    ]);
    }
}
