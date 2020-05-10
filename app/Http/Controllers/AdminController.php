<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function block(Request $request){

        $block = $request->get('block');

        User::where('id',$block)
            ->update(
                [
                    'bloqueado'=>1,
                ]
            );
        Auth::user()->save();

        return back()->with('message',"Blocked successfully");
    }
}
