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

        $request->validate([
            'foto'=>['nullable'],
        ]);




        if($request->hasFile('foto')){
            $path = $request->foto->store('public/fotos');
            $foto = basename($path);
        }
        else{
            $foto = null;
        }

        User::where('id',Auth::User()->id)
            ->update(
                [
                    'foto'=>$foto,
                ]
            );


        Auth::user()->save();

        return back()->with('message','Profile updated');
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
