<?php

namespace App\Orchid\Screens\Subscribers;

use App\Models\User;
use App\Orchid\Layouts\Subscribers\SubscribersLayout;
use App\Services\Guzzle;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Orchid\Screen\Actions\Link;
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

        try {
            $response = (new Guzzle)->get('/api/subscribers', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token['access_token'],
                    'Accept' => 'application/json',
                ],
            ]);
        } catch (BadResponseException $e) {
            return $e;
        }

        $subscribers = json_decode($response->getBody()->getContents(), true);

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
            Link::make('Add')
                ->route('platform.subscriber.add'),
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
