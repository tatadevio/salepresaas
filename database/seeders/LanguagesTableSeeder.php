<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('languages')->delete();
        
        \DB::table('languages')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => 'en',
                'name' => 'English',
                'is_default' => 1,
                'created_at' => '2023-05-26 21:11:26',
                'updated_at' => '2024-03-19 11:41:56',
                'is_active' => 1,
            ),
            1 => 
            array (
                'id' => 5,
                'code' => 'Es',
                'name' => 'Spanish',
                'is_default' => 0,
                'created_at' => '2023-11-13 13:13:58',
                'updated_at' => '2023-11-13 13:13:58',
                'is_active' => 1,
            ),
            2 => 
            array (
                'id' => 7,
                'code' => 'hindi',
                'name' => 'hindi',
                'is_default' => 0,
                'created_at' => '2024-03-19 11:45:52',
                'updated_at' => '2024-03-19 12:05:12',
                'is_active' => 0,
            ),
        ));
        
        
    }
}