<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GeneralSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('general_settings')->delete();
        
        \DB::table('general_settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'site_title' => 'SalePro POS SaaS',
                'meta_title' => 'SalePro SAAS inventory, POS, accounting & HRM',
                'meta_description' => 'SalePro SAAS lets your customers subscribe to SalePro inventory, POS, accounting & HRM solution',
                'og_title' => 'SalePro SAAS inventory, POS, accounting & HRM',
                'og_description' => 'SalePro SAAS lets your customers subscribe to SalePro inventory, POS, accounting & HRM solution',
                'og_image' => '20230307010632.jpg',
                'site_logo' => '20231113033910.png',
                'is_rtl' => 0,
                'date_format' => 'd-m-Y',
                'currency' => 'USD',
                'frontend_layout' => 'regular',
                'currency_position' => NULL,
                'developed_by' => 'LionCoders inc',
                'phone' => '+8801924-756759',
                'email' => 'support@lion-coders.com',
                'dedicated_ip' => '192.168.x.x',
                'free_trial_limit' => 7.0,
                'chat_script' => '<!-- Chat Snippet Start -->

<!-- Chat Snippet End -->',
                'ga_script' => '<!-- Google Analytics Snippet Start -->

<!-- Google Analytics Snippet End -->',
                'fb_pixel_script' => '<!-- Meta Pixel Snippet Start -->

<!-- Meta Pixel Snippet End -->',
                'active_payment_gateway' => 'stripe,paypal,razorpay,paystack,paydunya',
                'stripe_public_key' => 'pk_test_ITN7KOYiIsHSCQ0UMRcgaYUB',
                'paystack_public_key' => 'pk_live_e502618b3f4fa0a191c103c54174d8834dea0a33',
                'stripe_secret_key' => 'sk_test_TtQQaawhEYRwa3mU9CzttrEy',
                'paystack_secret_key' => 'sk_live_04f265b27ad0a544264a301f3de74dc4e7ca0e58',
                'paypal_client_id' => 'AVXqSGjiosZtSXuQhgnivmvOegq-eroZMmAkpTi5GDWN3F43Bg3wRyVmdjn0nL0M2n-_-L_9rTnwYmF8',
                'paypal_client_secret' => 'EC1_WSFDvKRXXSbIdGT9xZaBWRLUEqGgRbLcgdCHHscMoQkh-twx4G2pWcJ53mSoo8NetpHqiVNl0SQ3',
                'razorpay_number' => '9096123456',
                'razorpay_key' => 'rzp_test_abYWoiM35Szghv',
                'razorpay_secret' => 'V7uOhUx8MPKvOiQDSk9Jmabd',
                'created_at' => '2018-07-06 06:13:11',
                'updated_at' => '2023-11-13 15:39:10',
                'paydunya_master_key' => 'imz2j18m-nt2B-ebbf-ACjd-YnYrCkxJVMCE',
                'paydunya_public_key' => 'test_public_28a3EYgAKNYY7B8T2ZktOtHWLPW',
                'paydunya_secret_key' => 'test_private_XLTWcRb3NseYztPyxXgVrO9QjUT',
                'paydunya_token' => 'XAvChQWo5WFq5UrzxH7y',
            ),
        ));
        
        
    }
}