<?php

namespace App\Orchid\Layouts\Product;

use App\Models\Category;
use App\Models\Product;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ProductLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'products';

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
            TD::make('description'),
            TD::make('price'),
            TD::make('category.name', 'Category'),
            TD::make()
                ->render(function (Product $product) {
                    return Link::make('EDIT')
                                ->route('platform.product.edit', $product);
                }),
            TD::make()
                ->render(function (Product $product) {
                    return Button::make('DELETE')
                        ->method('destroy')
                        ->parameters(['product' => $product->id]);
                })
        ];
    }
}
