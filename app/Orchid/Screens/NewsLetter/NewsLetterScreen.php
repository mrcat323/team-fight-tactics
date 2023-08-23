<?php

namespace App\Orchid\Screens\NewsLetter;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class NewsLetterScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'NewsLetterScreen';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('send')
                ->method('send'),
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
            Layout::rows([
                Input::make('title')
                    ->type('text')
                    ->title('Title:'),
                Input::make('content')
                    ->type('text')
                    ->title('Content:'),
            ])
        ];
    }

    public function send(Request $request)
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

            $status = 0;
            $response = $client->post('api/newsletter', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'title' => $request->title,
                    'content' => $request->content,
                ],
            ]);

            if ($response->getStatusCode() === 200) {
                return response()->json([
                    'status' => 'OK'
                ]);
            }
            else {
                return response()->json([
                    'status' => 'False'
                ]);
            }
        }
    }
}
