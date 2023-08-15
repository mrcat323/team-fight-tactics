<?php

namespace App\Orchid\Screens\Category;

use App\Models\Category;
use App\Orchid\Layouts\Category\CategoryLayout;
use Orchid\Screen\Layout;
use Orchid\Screen\Layouts\Accordion;
use Orchid\Screen\Screen;

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
            'categories' => Category::paginate(15)
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
            CategoryLayout::class
        ];
    }
}
