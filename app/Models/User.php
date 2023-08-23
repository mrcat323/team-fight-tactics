<?php

namespace App\Models;

use GuzzleHttp\Client;
use Orchid\Platform\Models\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'permissions',
        'hash',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'permissions',
    ];

    protected $casts = [
        'permissions' => 'array',
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    public function getJWTCustomClaims()
    {
        return [];
    }

    public static function getToken()
    {
        $HOST = env('SOUL_HOST') . ":" . env('SOUL_PORT');
        $client = new Client([
            'base_uri' => $HOST
        ]);
        $response = $client->post('api/login', [
            'json' => [
                'email' => env('SOUL_USER'),
                'password' => env('SOUL_PASSWORD'),
            ],
        ]);
        if ($response->getStatusCode() === 200) {
            $token = json_decode($response->getBody(), true);
            return $token;
        }
        else {
            return 0;
        }
    }
}
