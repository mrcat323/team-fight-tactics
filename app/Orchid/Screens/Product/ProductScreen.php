<?php

namespace App\Orchid\Screens\Product;

use App\Models\Category;
use App\Models\Product;
use App\Orchid\Layouts\Product\ProductLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Illuminate\Support\Str;

class ProductScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        $products = Product::with('category')->paginate();
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
        return [
            Link::make('Add')
                ->route('platform.product.add'),
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
            ProductLayout::class,
        ];
    }

    public function destroy(Request $request)
    {
        $product = Product::find($request->product);

        $product->delete();

        return redirect()->route('platform.product');

    }
}
