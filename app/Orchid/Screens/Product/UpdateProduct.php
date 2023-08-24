<?php

namespace App\Orchid\Screens\Product;

use App\Models\Category;
use App\Models\Product;
use App\Models\Tags;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class UpdateProduct extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(Product $product): iterable
    {
        $tags = '';
        foreach ($product->tags as $tag) {
            $tags .= ',' . $tag->name ;
        }
        $tags[0] = ' ';

        return [
            'product' => $product,
            'tags' => $tags
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'UpdateProduct';
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
                ->method('update')
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
                Input::make('product.name')
                    ->type('text')
                    ->title('Product name:'),
                Input::make('product.description')
                    ->type('text')
                    ->title('Product description:'),
                Input::make('product.price')
                    ->type('text')
                    ->title('Product price:'),
                Select::make('category_id')
                    ->fromModel(Category::class, 'name')
                    ->title('Category'),
                Input::make('tags')
                    ->type('text')
                    ->title('Tags (comma-separated)')
            ])];
    }

    public function update(Product $product, Request $request)
    {
        $name = $request->input('product.name');
        $description = $request->input('product.description');
        $price = $request->input('product.price');
        $tagsInput = $request->input('tags');

        $product->update([
            'name' => $name,
            'description' => $description,
            'price' => $price
        ]);

        $product->tags()->detach();

        if ($tagsInput) {
            $tagNames = explode(',', $tagsInput);

            foreach ($tagNames as $tagName) {
                $tag = Tags::firstOrCreate(['name' => trim($tagName)]);
                $product->tags()->attach($tag);
            }
        }

        return redirect()->route('platform.products');
    }
}
