<?php

namespace App\Orchid\Layouts\Category;

use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CategoryLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'categories';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [

            TD::make('id'),
            TD::make('name'),
            TD::make()
                ->render(fn($category) => Link::make('EDIT')->route('platform.category.edit', $category)),
               TD::make()
                ->render(fn($category) => Link::make('DELETE')->route('platform.category.delete', $category)),
        ];
    }
}
