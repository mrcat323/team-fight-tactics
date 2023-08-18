<?php


namespace App\Http\Controllers;

use App\Models\Tags;

class TagController extends Controller
{
    public function index()
    {
        $tag = Tags::all();
        return response()->json($tag);
    }

    public function show($id)
    {
        $tag = Tags::with('products')->findOrFail($id);
        return response()->json($tag);
    }

}
