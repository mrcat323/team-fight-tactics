<?php


namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::all();
        return response()->json($category);
    }

    public function show($id)
    {
        $category = Category::with('products')->findOrFail($id);
        return response()->json($category);
    }
}
