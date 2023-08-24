<?php

namespace App\Orchid\Screens\Product;

use App\Jobs\ProductJob;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcribers;
use App\Models\Tags;
use App\Models\User;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
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
                    ->title('Product name:'),
                Input::make('description')
                    ->type('text')
                    ->title('Product description:'),
                Input::make('price')
                    ->type('text')
                    ->title('Product price:'),
                Select::make('category_id')
                    ->fromModel(Category::class, 'name')
                    ->title('Category'),
                Input::make('tags')
                    ->type('text')
                    ->required()
                    ->title('Tags (comma-separated)')
            ])];
    }

    public function create(Request $request)
    {
        $tagsInput = $request->input('tags');

        $category = Category::find($request->category_id);
        $product = $category->products()->create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price
        ]);

        $tagNames = explode(',', $tagsInput);

        foreach ($tagNames as $tagName) {
            $tag = Tags::firstOrCreate(['name' => trim($tagName)]);
            $product->tags()->attach($tag);
        }

        return redirect()->route('platform.products');

    }
}
