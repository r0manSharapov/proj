<?php

namespace App\Http\Controllers;

use App\Conta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

use App\User;


class PrivateAreaController extends Controller
{
    public function index(Request $request, User $user){
        $contas = Conta::where('user_id', $user->id)
        ->get(); //buscar contas so de 1 pessoa
        return view('privateArea.index')->withContas($contas);
    }


    public function store($request){

        $request->validate([
            'name'=>['required'],
            'startBalance'=>['required']

        ]);

    }

}
