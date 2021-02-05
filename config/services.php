<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */
    // b76d29633e7780b1be8e23e8748dea55aed80221
    'github' => [
        'client_id' => 'f7c0d98848bfb6ac420a',
        'client_secret' => 'b76d29633e7780b1be8e23e8748dea55aed80221',
        'redirect' => 'https://169.254.119.64/auth/github/callback',
    ],

    'google' => [
        'client_id' => '120216774444-ocdfpfrh3dogcc6s3ml320j8n0k1d440.apps.googleusercontent.com',         // Your GitHub Client ID
        'client_secret' => 'MGBKSzrh3QTvmGs9iRgWtMPH',
        'redirect' => 'https://169.254.119.64/result/google',
    ],

];
