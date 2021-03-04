<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Reset Password
    |--------------------------------------------------------------------------
    |
    | Insert your reset password url to inject into the email.
    |
    */
    'allowed-reset-password-url' => '/password-reset',

    /*
    |--------------------------------------------------------------------------
    | Verification Email
    |--------------------------------------------------------------------------
    |
    | Part of verification email urls to inject into the email.
    |
    */
    'email-verify-url' => '/verify-email',

    /*
    | TTL links for email verification.
    |
    */
    'verification'     => [
        'expire' => 60,
    ],
];
