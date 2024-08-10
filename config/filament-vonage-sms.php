<?php

return [
    'key' => env('VONAGE_KEY'),
    'secret' => env('VONAGE_SECRET'),
    'from' => env('VONAGE_SMS_FROM'),
    'user_model' => \App\Models\User::class,
];
