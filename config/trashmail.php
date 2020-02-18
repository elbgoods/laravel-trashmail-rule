<?php

use GuzzleHttp\RequestOptions;

return [
    /*
     * The list of providers that should run to decide whether an email is disposable or not.
     * The order of providers is respected - so you should put the fastest or most important ones at the top.
     */
    'providers' => [
        'config',
        'dead_letter',
    ],

    /*
     * This package can load a remote blacklist from https://www.dead-letter.email
     */
    'dead_letter' => [
        'enabled' => true,
        'cache' => [
            'enabled' => true,
            'store' => null,
            'key' => 'elbgoods.trashmail.dead_letter',
            'ttl' => 60 * 60 * 24, // one day
        ],
        'guzzle' => [
            RequestOptions::TIMEOUT => 10,
        ],
    ],

    /*
     * Here you can define your own blacklisted domains.
     */
    'blacklist' => [

    ],

    /*
     * Here you can list all domains you want to always allow.
     */
    'whitelist' => [

    ],
];
