<?php

namespace App\Orchid\Screens\Product;

use App\Models\Category;
use App\Models\Product;
use App\Orchid\Layouts\Product\ProductLayout;
use Orchid\Screen\Screen;
use Illuminate\Support\Str;

class ProdcutScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {

        $products = Product::with('category')->paginate(15);
        return [
            'products' => $products

        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Products';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            ProductLayout::class

        ];
    }
}
