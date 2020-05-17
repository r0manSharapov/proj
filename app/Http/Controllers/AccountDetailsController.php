<?php

namespace App\Http\Controllers;


use App\Categoria;
use App\Conta;
use App\User;
use App\Movimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;


class AccountDetailsController extends Controller
{
    public function index(User $user,Conta $conta ){

        $movimentos = Movimento::where('conta_id', $conta->id)
                    ->orderBy('data', 'desc')
                    ->paginate(6);


        return view('privateArea.accountDetails.index')->withMovimentos($movimentos)
                                           ->withConta($conta)->withUser($user);
    }

    public function search(User $user,Request $request, Conta $conta)
    {
        $search = $request->get('search');
        $movementsSearch = Movimento::where('data','like','%'.$search.'%')->where('conta_id', $conta->id);


        return view('privateArea.accountDetails.index')->withMovimentos($movementsSearch->paginate(6))
            ->withSearch($search)
            ->withConta($conta)->withUser($user);
    }

    public function showForm(User $user,Conta $conta){

        $categorias = Categoria::all();

        if(Route::currentRouteName()=='viewAddMovement') {
            return view('privateArea.accountDetails.form')->withUser($user)->withConta($conta)->withCategorias($categorias);
        }

    }

    public function store(Request $request, User $user,Conta $conta){



        $request->validate( [
            'data'=>['required','date'], //FAZER + VERIFICACOES PARA A DATA
            'valor'=>['required','numeric','between:0,99999999999.99'],
            'descricao'=>['nullable','string','max:255']

        ]);

        $categoria = $request->get('categoria');
        $tipo=$request->get('tipoMovimento');



        if($categoria != null && $categoria->tipo != $tipo){


            //retornar mensagem de erro
            return back()->with('error','Category type has to be the same of movement type');

        }

        $valor =$request->get('valor');
        $saldoInicial=$conta->saldo_atual;

        if($tipo == 'R'){

            $saldoFinal = $saldoInicial + $valor;
        }
        if($tipo=='D'){
            $saldoFinal = $saldoInicial - $valor;
        }

        $contaID= $conta->id;

        $movimento = Movimento::create([
            'conta_id'=> $contaID,
            'data'=>$request->get('data'),
            'valor'=> $valor,
            'descricao'=>$request->get('descricao'),
            'categoria'=>$categoria->id,
            'tipo'=> $tipo,
            'saldo_inical'=>$saldoInicial,
            'saldo_final'=>$saldoFinal,
            'imagem_doc'=>null,
            'deleted_at'=>null


        ]);

        $movimento->save();

        return redirect()->route('accountDetails',['user'=>$user,'conta'=>$conta])->with('message','Movement added successfully!');

    }
}
