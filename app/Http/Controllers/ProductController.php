<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::paginate(8);
        return response()->json($product);
    }
    public function show($id)
    {
        $product = Product::with(['category', 'tags'])->findOrFail($id);
        return response()->json($product);
    }

}
