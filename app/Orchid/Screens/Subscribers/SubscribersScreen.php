<?php

namespace App\Orchid\Screens\Subscribers;

use App\Http\Controllers\SubscribersController;
use App\Models\Subcribers;
use App\Orchid\Layouts\Subscribers\SubscribersLayout;
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
        $sub = Subcribers::paginate();
        return [
            'subscribers' => $sub,
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
