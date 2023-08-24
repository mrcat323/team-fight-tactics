<?php

namespace App\Services;

use GuzzleHttp\Client;

class Guzzle extends Client
{
    public function __construct()
    {
        $config = [
            'base_uri' => env('SOUL_HOST')
        ];

        parent::__construct($config);
    }
}
