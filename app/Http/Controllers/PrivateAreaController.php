<?php

namespace App\Http\Controllers;

use App\Conta;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


use Illuminate\Support\Facades\Auth;

use App\User;
use Illuminate\Validation\Rule;


class PrivateAreaController extends Controller
{
    public function show( User $user){
        $contas = Conta::withTrashed()->where('user_id', $user->id)->get(); //buscar contas so de 1 pessoa
        return view('privateArea.index')->withContas($contas)->withUser($user);
    }


    public function showAddAccount(User $user){

        return view('privateArea.form')->withUser($user);

    }


    public function store(Request $request, User $user){

        $request->validate([
            'name'=>['required','string', 'max:255'],
            'startBalance'=>['required','numeric'],
            'description'=>['string']

        ]);

        $userId= $user->id;
      $conta = Conta::create([
            'user_id'=>$userId,
          'nome'=>$request->get('name'),
          'descricao'=>$request->get('description'),
          'saldo_abertura'=>$request->get('startBalance'),
          'saldo_atual'=>$request->get('startBalance'),
          'data_ultimo_movimento'=> now(),
          'deleted_at'=> null

      ]);

    $conta->save();

  return redirect()->route('privateArea',['user'=>$user]);

    }
}
