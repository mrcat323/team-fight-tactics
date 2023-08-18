<?php


namespace App\Http\Controllers;

use App\Http\Resources\TagResource;
use App\Models\Tags;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $tag = Tags::all();
        return response()->json($tag);
    }

    public function show($id)
    {
        $tag = Tags::findOrFail($id);
        return response()->json($tag);
    }

}
