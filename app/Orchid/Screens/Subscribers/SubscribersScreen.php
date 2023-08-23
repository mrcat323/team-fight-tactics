<?php

namespace App\Orchid\Screens\Subscribers;

use App\Models\User;
use App\Orchid\Layouts\Subscribers\SubscribersLayout;
use GuzzleHttp\Client;
use Orchid\Screen\Screen;

class SubscribersScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {

        $token = User::getToken();
        $HOST = env('SOUL_HOST') . ":" . env('SOUL_PORT');
        $client = new Client([
            'base_uri' => $HOST
        ]);
        $response = $client->get('api/subscribers', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ],
        ]);
        $subscribers = json_decode($response->getBody()->getContents(), true);
//        dd($subscribers);

        return [
            'subscribers' => $subscribers,
        ];

    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Subscribers';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [

        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            SubscribersLayout::class,
        ];
    }
}
