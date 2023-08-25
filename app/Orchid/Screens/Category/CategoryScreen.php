<?php

namespace App\Orchid\Screens\Category;

use App\Models\Category;
use App\Models\Product;
use App\Orchid\Layouts\Category\CategoryLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layout;
use Orchid\Screen\Layouts\Accordion;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
class CategoryScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'categories' => Category::paginate()
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Category';
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
                ->route('platform.category.add'),
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
            CategoryLayout::class,
        ];
    }

    public function destroy(Request $request)
    {
        $category = Category::find($request->category);
        $category->products()->delete();
        $category->delete();

        return redirect()->route('platform.category');

    }
}
