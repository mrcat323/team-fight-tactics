<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::all();
        return response()->json($category);
    }
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }
}
