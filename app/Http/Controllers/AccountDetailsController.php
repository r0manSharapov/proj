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

        $movimentos = Movimento::join('categorias','movimentos.categoria_id','=','categorias.id')
                    ->where('movimentos.conta_id', $conta->id)
                    ->orderBy('movimentos.data', 'desc')
                    ->paginate(6);

       //passa o nome da categoria como "nome"

        return view('privateArea.accountDetails.index')->withMovimentos($movimentos)
                                           ->withConta($conta)->withUser($user);
    }

    public function search(User $user,Request $request, Conta $conta)
    {
        $search = $request->get('search');
        $movementsSearch =
            Movimento::join('categorias','movimentos.categoria_id','=','categorias.id')
                ->where(function ($query) use($search) {
                    $query->where('movimentos.data','like','%'.$search.'%')
                                      ->orwhere('categorias.nome','like','%'.$search.'%');
                })
                ->where('conta_id', $conta->id)->orderBy('movimentos.data', 'desc');




        $movementType = $request->get('movementType');
        if ($movementType != 0) {
            if ($movementType == 1) {

                $movementsSearch->where('movimentos.tipo', 'R');

            }
            if ($movementType == 2) {
                $movementsSearch->where('movimentos.tipo', 'D');
            }
            return view('privateArea.accountDetails.index')->withMovimentos($movementsSearch->paginate(6))
                ->withSearch($search)
                ->withMovementType($movementType)
                ->withConta($conta)->withUser($user);
        }

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

    public function showMoreInfo(Movimento $movimento){
        $movimento->id;
        return view('privateArea.accountDetails.moreInfo')->withMovimento($movimento);
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
