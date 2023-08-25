<?php

namespace App\Orchid\Layouts\Subscribers;

use App\Models\User;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SubscribersLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'subscribers';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id')
                ->render(function ($subscriber) {
                    return $subscriber['id'];
                }),
            TD::make('email')
                ->render(function ($subscriber) {
                    return $subscriber['email'];
                }),
        ];
    }
}
