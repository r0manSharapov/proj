<?php

namespace App\Http\Controllers;

use App\Conta;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class PrivateAreaController extends Controller
{
    public function show( User $user){
        $contas = Conta::withTrashed()->where('user_id', $user->id)->get(); //buscar contas so de 1 pessoa
        return view('privateArea.index')->withContas($contas)->withUser($user);
    }


    public function showForm(User $user,Conta $conta){

        if(Route::currentRouteName()=='viewAddAccount') {
            return view('privateArea.form')->withUser($user);
        }
        //se estiver na rota do update
        return view('privateArea.form')->withUser($user)->withConta($conta);

    }


    public function store(Request $request, User $user){

       $request->validate( [
            'name'=>['required','string', 'max:20',Rule::unique('contas', 'nome')->ignore($user->id)],
            'startBalance'=>['required','numeric'],
            'description'=>['nullable','string']

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

  return redirect()->route('privateArea',['user'=>$user])->with('message','Account added successfully!');

    }


    public function updateAccount(Request $request, User $user,Conta $conta){

        $request->validate( [
            'name'=>['required','string', 'max:20'],
            'startBalance'=>['required','numeric'],
            'currentBalance'=>['required','numeric'],
            'description'=>['nullable','string']

        ]);


       $contaId=$conta->id;

        Conta::where('id',$contaId)
        ->update(
            [
                'nome'=>$request->name,
                'saldo_abertura'=>$request->get('startBalance'),
                'saldo_atual'=>$request->get('currentBalance'),
                'descricao'=>$request->get('description'),


            ]
        )->save();


        return redirect()->route('privateArea',['user'=>$user])->with('message','Account updated successfully!');
    }
}
