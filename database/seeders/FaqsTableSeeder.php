<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FaqsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('faqs')->delete();
        
        \DB::table('faqs')->insert(array (
            0 => 
            array (
                'id' => 1,
                'question' => 'Do I need to purchase hosting?',
                'answer' => 'No, you don\'t need to purchase hosting or install anything anywhere. Just log into your designated admin panel from anywhere, anytime and you\'ll be to access all your software.',
                'order' => 2,
                'created_at' => '2023-03-08 13:12:41',
                'updated_at' => '2023-03-08 13:12:41',
            ),
            1 => 
            array (
                'id' => 2,
                'question' => 'What hardware does it support?',
            'answer' => 'Barcode Scanner, barcode label printer, Receipt or Thermal Printer (Printer with ESC/POS commands), digital weighing scale etc.',
                'order' => 1,
                'created_at' => '2023-03-08 13:12:41',
                'updated_at' => '2023-03-08 14:10:01',
            ),
            2 => 
            array (
                'id' => 4,
                'question' => 'Can I renew my subscription on my own',
                'answer' => 'Yes you can',
                'order' => 1,
                'created_at' => '2023-11-13 14:06:28',
                'updated_at' => '2023-11-13 14:06:28',
            ),
        ));
        
        
    }
}