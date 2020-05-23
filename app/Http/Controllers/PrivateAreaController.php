<?php

namespace App\Http\Controllers;

use App\Conta;
use App\Movimento;
use App\Autorizacoes_conta;

use Illuminate\Http\Request;



use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class PrivateAreaController extends Controller
{


    public function show(User $user){
        //dd($user);
       //$this->authorize('view',$user);
        $contas = Conta::withTrashed()->where('user_id', $user->id)->get(); //buscar contas so de 1 pessoa

       // $contasPartilhadas = Autorizacoes_conta::where('user_id', $user->id)->get();
        //dd($contasPartilhadas);
        //$informacaoContas = Conta::where('id', $contasPartilhadas->conta_id)->with('user')->get();
//        return view('privateArea.contas.index')->withContas($contas)->withInformacaoContas($informacaoContas)->withUser($user);
       return view('privateArea.contas.index')->withContas($contas)->withUser($user);

    }


    public function showForm(User $user,Conta $conta){

        if(Route::currentRouteName()=='viewAddAccount') {
            return view('privateArea.contas.form')->withUser($user);
        }
        //se estiver na rota do update
        return view('privateArea.contas.form')->withUser($user)->withConta($conta);

    }


    public function store(Request $request, User $user){

       $request->validate( [
            'name'=>['required','string', 'max:20',Rule::unique('contas', 'nome') ->where(function ($query) use ($user) {
                return $query->where('user_id', $user->id);
            }) ],//A conta tem de ter um nome diferente das contas do proprio user
            'startBalance'=>['required','numeric','between:0,99999999999.99'], //porque o tipo de dados é decimal(11,2)
            'description'=>['nullable','string','max:255'] //VARCHAR(255) e optional

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
            'name'=>['required','string', 'max:20',Rule::unique('contas', 'nome')->where(function ($query) use ($user) {
            return $query->where('user_id', $user->id);
        })->ignore($conta)], //A conta tem de ter um nome diferente das contas do proprio user e ignora se é igual ao antigo nome
            'startBalance'=>['required','numeric','between:0,99999999999.99'], //porque o tipo de dados é decimal(11,2)
            'currentBalance'=>['required','numeric','between:0,99999999999.99'],
            'description'=>['nullable','string','max:255'] //VARCHAR(255) e optional
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
        );


        return redirect()->route('privateArea',['user'=>$user])->with('message','Account updated successfully!');
    }
}
