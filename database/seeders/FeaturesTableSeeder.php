<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FeaturesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('features')->delete();
        
        \DB::table('features')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Variants, IMEI/Serial Number, batch & expiry dates',
                'icon' => 'fa fa-bolt',
                'order' => 2,
                'created_at' => '2023-03-09 13:20:02',
                'updated_at' => '2023-03-09 13:20:02',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'TAX/VAT, Indian GST management',
                'icon' => 'fa fa-comment',
                'order' => 1,
                'created_at' => '2023-03-09 13:20:02',
                'updated_at' => '2023-03-09 13:20:02',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Currency conversion',
                'icon' => 'fa fa-ticket',
                'order' => 3,
                'created_at' => '2023-03-09 13:20:02',
                'updated_at' => '2023-03-09 13:20:02',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Comprehensive Report',
                'icon' => 'fa fa-bar-chart',
                'order' => 1,
                'created_at' => '2023-11-13 14:04:34',
                'updated_at' => '2023-11-13 14:04:34',
            ),
        ));
        
        
    }
}