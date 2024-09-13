<?php

return [
    "bkash_version" => "v1.2.0-beta",
    "bkash_sandbox" => env("BKASH_TOKENIZE_SANDBOX", ""),
    "bkash_base_url" => env("BKASH_TOKENIZE_BASE_URL", ""),
    "bkash_callback_url"  => 'https://'.env('CENTRAL_DOMAIN').'/bkash_payment_success',
    'bkash_timezone' => 'Asia/Dhaka',
];
