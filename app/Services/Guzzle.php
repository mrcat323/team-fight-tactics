<?php 

namespace App\Services;

use GuzzleHttp\Client;

class Guzzle
{
    public function __construct()
    {
        $client = new Client([
            'base_uri' => env('SOUL_HOST')
        ]);

        return $client;
    }
}