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
        $usersSearch = User::where(function ($query) use($search) {
            $query->where('name','like','%'.$search.'%')
                ->orwhere('email','like','%'.$search.'%');
        });

        $is_adm =  Auth::user()->adm;

        if($is_adm == 1)
        {
            $userType = $request->get('userType');
            if($userType==1){

                $usersSearch= $usersSearch->where('adm',1);

            }
            if($userType==2){
                $usersSearch=$usersSearch->where('adm',0);
            }

            $blocked = $request->get('blocked');
            if($blocked){
                $usersSearch=$usersSearch->where('bloqueado',1);
            }

        

            return view('usersList')->withAllUsers($usersSearch->paginate(5))
                ->withSearch($search)
                ->withUserType($userType)
                ->withBlocked($blocked);
        }

        return view('usersList')->withAllUsers($usersSearch->paginate(5))
            ->withSearch($search);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('profile')->withUser($user);
    }

    public function block(Request $request){
        $block=$request->get('block'); //block é suposto obter o id do user escolhido que vai estar no value 
        //quando as rotas para os perfis já funcionarem, com um botão para bloquear

        User::where('id',$block)
            ->update(
                [
                    'bloqueado'=>1,
                ]
            );

        Auth::user()->save();
    }
}
