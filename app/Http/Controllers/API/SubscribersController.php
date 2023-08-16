<?php

namespace App\Http\Controllers\API;

use App\Models\Subcribers;
use Illuminate\Http\Request;

class SubscribersController extends Controller
{
    public function store(Request $request)
    {
        $subscribers = Subcribers::create($request->all());

        return $subscribers;
    }
    public function SetStatus( Subcribers $subscribers , Request $request){
        $subscribers = Subcribers::where('id' ,$request);
        if($subscribers->status){
            dd($subscribers);
        }
    }
}
