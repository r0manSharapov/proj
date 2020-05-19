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
    public function index(User $user,Conta $conta){

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

    public function showForm(User $user,Conta $conta,Movimento $movimento){

        $categorias = Categoria::all();


        if(Route::currentRouteName()=='viewAddMovement') {
            return view('privateArea.accountDetails.form')->withUser($user)->withConta($conta)->withCategorias($categorias);
        }
        if(Route::currentRouteName()=='viewUpdateMovement') {
            return view('privateArea.accountDetails.form')->withUser($user)->withConta($conta)->withCategorias($categorias)->withMovimento($movimento);
        }
    }

    public function showMoreInfo(Movimento $movimento){

        return view('privateArea.accountDetails.moreInfo')->withMovimento($movimento);
    }

    public function store(Request $request, User $user,Conta $conta){



        $request->validate( [
            'data'=>['required','date'],
            'valor'=>['required','numeric','between:0.01,99999999999.99'],
            'descricao'=>['nullable','string','max:255'],

        ]);

        $categoria_id = $request->get('categoria_id');


        $categoria = Categoria::where('id',$categoria_id)
            ->select('tipo')->get();

        $tipo=$request->get('tipoMovimento');



        if($categoria_id != null && $categoria[0]->tipo != $tipo){
            //retornar mensagem de erro se o tipo de categoria diferente do tipo do movimento
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


        //UPDATE SALDO DA CONTA

        Conta::where('id',$conta->id)
            ->update(
                ['saldo_atual'=> $saldoFinal]
            );

        //


        $movimento = Movimento::create([
            'conta_id'=> $contaID,
            'data'=>$request->get('data'),
            'valor'=> $valor,
            'descricao'=>$request->get('descricao'),
            'categoria_id'=>$categoria_id,
            'tipo'=> $tipo,
            'saldo_inicial'=>$saldoInicial,
            'saldo_final'=>$saldoFinal,
            'imagem_doc'=>null,
            'deleted_at'=>null


        ]);


        $movimento->save();

        return redirect()->route('accountDetails',['user'=>$user,'conta'=>$conta])->with('message','Movement added successfully!');

    }


    public function updateMovement(Request $request, User $user,Conta $conta,Movimento $movimento){



        $request->validate( [
            'data'=>['required','date'],
            'valor'=>['required','numeric','between:0.01,99999999999.99'],
            'descricao'=>['nullable','string','max:255'],

        ]);

        $alterCatType= $request->get('alterCatType');
        $alterMoveType=$request->get('alterMovType');

        if($alterCatType==null) // se nao quiser alterar o tipo de categoria
        {
            $categoria_id = $movimento->categoria_id;
        }
        if($alterMoveType == null){ //se nao quiser alterar o tipo de move
            $tipo = $movimento->tipo;
        }

        if($alterMoveType) { //se quiser alterar o tipo de move
            $tipo = $request->get('tipoMovimento');

        }
        if($alterCatType) { //se quiser alterar o tipo de cat
            $categoria_id = $request->get('categoria_id');

        }

        $categoria = Categoria::where('id', $categoria_id)
            ->select('tipo')->get();

        if ($categoria_id != null && $categoria[0]->tipo != $tipo) {
            //retornar mensagem de erro se o tipo de categoria diferente do tipo do movimento
            return back()->with('error', 'Category type has to be the same of movement type');

        }


            $valor = $request->get('valor');
        $contaID = $conta->id;

if($alterMoveType) { //se alterar o tipo de movimento atulizar saldo inicial e final e saldo de conta

    $saldoInicial = $conta->saldo_atual;
    if ($tipo == 'R') {
        $saldoInicial=$saldoInicial-$movimento->valor; // anula o movimento
        $saldoFinal = $saldoInicial + $valor;

    }
    if ($tipo == 'D') {
        $saldoInicial=$saldoInicial+$movimento->valor; //anula o movimento
        $saldoFinal = $saldoInicial - $valor;
    }





    //UPDATE SALDO DA CONTA

    Conta::where('id', $conta->id)
        ->update(
            ['saldo_atual' => $saldoFinal]
        );

    //

}else{ //se nao alterar fica igual

    $saldoInicial=$movimento->saldo_inicial;
        $saldoFinal=$movimento->saldo_final;

}

$movimento_id = $movimento->id;
            Movimento::where('id',$movimento_id)
                ->update([
                'conta_id' => $contaID,
                'data' => $request->get('data'),
                'valor' => $valor,
                'descricao' => $request->get('descricao'),
                'categoria_id' => $categoria_id,
                'tipo' => $tipo,
                'saldo_inicial' => $saldoInicial,
                'saldo_final' => $saldoFinal,
                'imagem_doc' => null,
                'deleted_at' => null


            ]);




        return redirect()->route('accountDetails',['user'=>$user,'conta'=>$conta])->with('message','Movement added successfully!');

    }
}
