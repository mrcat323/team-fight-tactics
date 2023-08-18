<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::all();
        return response()->json($product);
    }

    public function show($id)
    {
        $product = Product::with(['category', 'tags'])->findOrFail($id);
        return response()->json($product);
    }

}
