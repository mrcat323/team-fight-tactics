<?php

namespace App\Orchid\Screens\Subscribers;

use App\Models\User;
use App\Services\Guzzle;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class AddSubscribersScreen extends Screen
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
        return 'AddSubscribersScreen';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('save')
                ->method('store')
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
                Input::make('email')
                    ->type('text')
                    ->title('Email:'),
            ])];
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        $email = $validated['email'];
        $token = User::getToken();
        $client = new Guzzle();
        try {
            $response =$client->post('api/subscriber-add', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token['access_token'],
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'email' => $email
                ],

            ]);
        } catch (BadResponseException $e) {
            $response = $e->getResponse();

            return json_decode($response->getBody()->getContents(), true);
        }

        return redirect()->route('platform.subscribers');
    }
}
