<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use App\Events\PrivateMessage;
use Illuminate\Http\Request;

class StartController extends Controller
{
    public function sendMessage(Request $request)
    {
        event(new NewMessage($request->message));

        return view('welcome');
    }


    public function sendPrivateMessage(Request $request)
    {
//        event(new NewMessage($request->message));

        PrivateMessage::dispatch($request->all());

        return $request->all();
//        return view('welcome');
    }
}
