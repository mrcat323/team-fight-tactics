<?php

namespace App\Http\Controllers;

use App\Models\Subcribers;
use Illuminate\Http\Request;

class SubscribersController extends Controller
{
        public function Create(Request $request ){

        }
        public function SetStatus( Subcribers $subscribers , Request $request){
            $subscribers = Subcribers::where('id' ,$request);
            if($subscribers->status){
                dd($subscribers);
            }
        }
}
