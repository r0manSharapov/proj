<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
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
            'foto'=>['required'],
        ]);

        $old_foto = Auth::user()->foto;

//            unlink(storage_path('public/fotos'.$old_foto));
          Storage::delete('public/fotos/'. $old_foto);

        $path = $request->foto->store(('public/fotos'));
        $foto = basename($path);



        User::where('id',Auth::id())
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
        return redirect()->route('profile',Auth::id());
    }
}
