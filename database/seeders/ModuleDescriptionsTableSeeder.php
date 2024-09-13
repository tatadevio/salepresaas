<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ModuleDescriptionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('module_descriptions')->delete();
        
        \DB::table('module_descriptions')->insert(array (
            0 => 
            array (
                'id' => 2,
                'heading' => 'One App, all the features',
                'sub_heading' => 'SalePro is packed with all the features you\'ll need to seamlessly run your business',
                'image' => '20230716072050.png',
                'lang_id' => 1,
                'created_at' => '2023-05-23 16:28:16',
                'updated_at' => '2023-07-16 19:20:50',
            ),
            1 => 
            array (
                'id' => 4,
                'heading' => 'Una aplicación, todas las funciones',
                'sub_heading' => 'SalePro incluye todas las funciones que necesitará para administrar su negocio sin problemas',
                'image' => NULL,
                'lang_id' => 5,
                'created_at' => '2023-11-13 13:30:37',
                'updated_at' => '2023-11-13 13:30:37',
            ),
        ));
        
        
    }
}