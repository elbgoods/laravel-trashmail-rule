<?php

return [
    /*
     * The list of providers that should run to decide whether an email is disposable or not.
     * The order of providers is respected - so you should put the fastest or most important ones at the top.
     */
    'providers' => [
        'config',
        'disposable_email_detector',
        'verifier',
    ],

    /*
     * This package can do a request to https://www.disposable-email-detector.com
     */
    'disposable_email_detector' => [
        'enabled' => false,
    ],

    /*
     * This package can do a request to https://verifier.meetchopra.com
     */
    'verifier' => [
        'enabled' => false,
        'api_key' => env('VERIFIER_API_KEY'),
    ],

    /*
     * Here you can define your own list of denied domains.
     */
    'denied' => [

    ],

    /*
     * Here you can list all domains you want to always allow.
     */
    'allowed' => [

    ],
];
