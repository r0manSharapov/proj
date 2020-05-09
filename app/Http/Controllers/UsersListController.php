<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

use App\User;


class UsersListController extends Controller
{
    public function index(){
        $users= User::paginate(5);
        return view('usersList')->withAllUsers($users);
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $usersSearch = User::where('name','like','%'.$search.'%')->orwhere('email','like','%'.$search.'%')->paginate(5);

        $user =  Auth::user();

        return view('usersList')->withAllUsers($usersSearch)
            ->withSearch($search);
    }

    public function admin(Request $request)
    {
        $search = $request->get('search');
        $usersSearch = User::where('name','like','%'.$search.'%')->orwhere('email','like','%'.$search.'%')->paginate(5);

        $user =  Auth::user();

        return view('admin')->withAllUsers($usersSearch)
            ->withSearch($search);
    }
}
