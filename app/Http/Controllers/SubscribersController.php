<?php

namespace App\Http\Controllers;

use App\Models\Subcribers;
use Illuminate\Http\Request;

class SubscribersController extends Controller
{
    public function store(Request $request)
    {
        $subscribers = Subcribers::create($request->all());

        return $subscribers;
    }

}
