<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AdminController extends Controller
{
    public function index(){
        return back();
    }

    public function change(Request $request){
        $block = $request->get('block');
        $unblock = $request->get('unblock');

        if($block){
            User::where('id',$block)->update(['bloqueado'=> '1']);

            return back()->with('message',"Blocked successfully");
        }

        if($unblock){
            User::where('id',$unblock)->update(['bloqueado'=> '0']);

            return back()->with('message',"Unblocked successfully");
        }

        $admin = $request->get('admin');
        $user = $request->get('user');

        if($admin){
            User::where('id',$admin)->update(['adm'=> '1']);

            return back()->with('message',"Changed successfully to admin!");
        }

        if($user){
            User::where('id',$user)->update(['adm'=> '0']);

            return back()->with('message',"Changed successfully to normal user!");
        }

        return back();
    }
}
