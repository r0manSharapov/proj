<?php

namespace App\Http\Controllers;


use App\Categoria;
use App\Conta;
use App\User;
use App\Movimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;



class AccountDetailsController extends Controller
{

    private  function getCreatedAtAttribute($value)
    {
        $date = Carbon::parse($value);
        return $date->format('Y-m-d');
    }

    public function index(User $user,Conta $conta){


        $movimentos = Movimento::
                    where('conta_id', $conta->id)
                    ->with('categoria')
                    ->orderBy('data', 'desc')
                    ->paginate(6);



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
            return view('privateArea.accountDetails.form')->withUser($user)->withConta($conta)->withMovimento($movimento)->withCategorias($categorias);
        }
    }

    public function showMoreInfo(Movimento $movimento){

        return view('privateArea.accountDetails.moreInfo')->withMovimento($movimento);
    }
    public function show_foto(Movimento $movimento){

        return response()->file(storage_path('app/docs/' . $movimento->imagem_doc));
    }

    public function store(Request $request, User $user,Conta $conta){

        $request->validate( [
            'data'=>['required','date'],
            'valor'=>['required','numeric','between:0.01,99999999999.99'],
            'descricao'=>['nullable','string','max:255'],
            'imagem_doc'=>['nullable','image'],
        ]);
        $dataRecebida =$request->get('data');
        $data = $this->getCreatedAtAttribute($dataRecebida);
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

        $contaID= $conta->id;

        if($request->hasFile('imagem_doc')){
            $path = $request->imagem_doc->store('docs');
            $doc_image = basename($path);
        }else{
            $doc_image = null;
        }


        $movimento = Movimento::create([
            'conta_id'=> $contaID,
            'data'=>$data,
            'valor'=> $valor,
            'descricao'=>$request->get('descricao'),
            'categoria_id'=>$categoria_id,
            'tipo'=> $tipo,
            'saldo_inicial'=>0, // atualiza saldos depois
            'saldo_final'=>0,
            'imagem_doc'=>$doc_image,
            'deleted_at'=>null

        ]);

        $this->atualizaSaldos($data,$conta);

        $movimento->save();

        return redirect()->route('accountDetails',['user'=>$user,'conta'=>$conta])->with('message','Movement added successfully!');

    }


    public function updateMovement(Request $request, User $user,Conta $conta,Movimento $movimento){

        $request->validate( [
            'data'=>['required','date'],
            'valor'=>['required','numeric','between:0.01,99999999999.99'],
            'descricao'=>['nullable','string','max:255'],
            'imagem_doc'=>['nullable','image'],

        ]);

        $dataRecebida =$request->get('data');
        $data = $this->getCreatedAtAttribute($dataRecebida);

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



        $old_doc_image = $movimento->imagem_doc;
        if(\request()->hasFile('imagem_doc')) {
            Storage::delete(('docs/') . $old_doc_image);


            $path = $request->imagem_doc->store('docs');


            $imagem_doc = basename($path);

        }else{
            $imagem_doc = $old_doc_image;
        }

            $movimento_id = $movimento->id;
            Movimento::where('id',$movimento_id)
                ->update([
                'conta_id' => $contaID,
                'data' => $data,
                'valor' => $valor,
                'descricao' => $request->get('descricao'),
                'categoria_id' => $categoria_id,
                'tipo' => $tipo,
                'saldo_inicial' => 0,
                'saldo_final' => 0,
                'imagem_doc' => $imagem_doc,
                'deleted_at' => null


            ]);

            $this->atualizaSaldos($data,$conta);



        return redirect()->route('accountDetails',['user'=>$user,'conta'=>$conta])->with('message','Movement updated successfully!');

    }

    public function destroy($id)
    {
        $movimento = Movimento::where('id',$id)->first();
        $conta = Conta::where('id',$movimento->conta_id)->first();
        $data = $movimento->data;
        $movimento->forceDelete();

        $this->atualizaSaldos($data,$conta);
        return back()->with('message','Successfully deleted!');
    }

    public function atualizaSaldos($data, $conta)
    { //depois dessa data

        $ultimoMoveValido = Movimento::where('conta_id', $conta->id)
            ->where('data', '<', $data)
            ->orderBy('data', 'desc')->orderBy('id', 'desc')->first();

        //qual o primeiro saldo inicial
        if($ultimoMoveValido==null ){
            //se for o primeiro move
            $saldo_inicial= $conta->saldo_abertura;
        }else{

            $saldo_inicial=$ultimoMoveValido->saldo_final;
        }

        $movesAAlterar = Movimento::
        where('conta_id',$conta->id)
            ->where('data','>=',$data)
            ->orderBy('data')->orderBy('id')->get();

        foreach ($movesAAlterar as $moveAAlterar){

            $valor = $moveAAlterar->valor;

            if($moveAAlterar->tipo == 'D'){ //se for uma despesa
                $valor = - $valor;
            }

            $saldo_final = $saldo_inicial+$valor;
            Movimento::where('id',$moveAAlterar->id)
                ->update([
                    'saldo_inicial'=>$saldo_inicial,
                    'saldo_final'=>$saldo_final
                ]);

            $saldo_inicial= $saldo_final;
        }

        //atualiza a conta com o saldo final do ultimo movimento atualizado
        Conta::where('id',$conta->id)->update(
            [
                'saldo_atual'=>$saldo_final, // o ultimo que sai do foreach
            ]
        );
    }
}
