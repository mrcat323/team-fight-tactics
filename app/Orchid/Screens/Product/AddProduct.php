<?php

namespace App\Orchid\Screens\Product;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class AddProduct extends Screen
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
        return 'AddProduct';
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
            ->method('create')
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
            Input::make('name')
                ->type('text')
                ->title('Product name:')   ,
        Input::make('description')
                ->type('text')
                ->title('Product description:'),
        Input::make('price')
                ->type('text')
                ->title('Product price:'),
        Input::make('category_id')
                ->type('text')
                ->title('Category name:')
        ])];
    }
    public function create(Request $request)
    {
        $product = Product::create($request->all());
        return redirect()->route('platform.product');
    }
}
