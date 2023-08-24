<?php

namespace App\Orchid\Screens\NewsLetter;

use App\Models\User;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use App\Services\Guzzle;

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
        if ($token = User::getToken()) {
            $data = $request->only(['title', 'content']);
            return $this->newsletter($token, $data);
        }
    }

    public function newsletter($token, $data)
    {
        try {
            $response = (new Guzzle)->post('/api/newsletter', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/json'
                ],
                'json' => [
                    'title' => $data['title'],
                    'content' => $data['content']
                ]
            ]);
        } catch (BadResponseException $e) {
            $response = $e->getResponse();

            return json_decode($response->getBody()->getContents(), true);
        }

        return json_decode($response->getBody()->getContents(), true);
    }
}
