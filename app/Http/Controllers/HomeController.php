<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

use App\User;


class HomeController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function store(Request $request){
        if($request->hasFile('foto')){
            $path = $request->foto->store('public/fotos');
            basename($path);
        }
    }


    public function index()
    {
        return view('home');

    }


    public function getUsersList()
    {
        $users = User::all();


        return view('usersList')
            ->withAllUsers($users);

    }
}
