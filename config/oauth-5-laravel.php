<?php

use OAuth\Common\Storage\Session;

return [

    /*
    |--------------------------------------------------------------------------
    | oAuth Config
    |--------------------------------------------------------------------------
    */

    /**
     * Storage
     */
    'storage' => new Session(),

    /**
     * Consumers
     */
    'consumers' => [

        /**
         * Google
         */
        'Google' => [
            'client_id'     => env('GOOGLE_CLIENT_ID'),
            'client_secret' => env('GOOGLE_SECRET_ID'),
            'scope'         => ['userinfo_email', 'userinfo_profile', 'https://www.google.com/m8/feeds/'],
        ],

    ]

];