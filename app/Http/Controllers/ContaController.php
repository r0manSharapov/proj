<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Conta;
use App\Movimento;
use App\Autorizacoes_conta;

class ContaController extends Controller
{

    public function softDelete(Conta $conta)
    {
        $id = $conta->id;
        $conta_delete = Conta::where('id', $id);
        $conta_delete->delete();
        Autorizacoes_conta::where('conta_id',$id)->delete();

        Movimento::where('conta_id',$id)->delete();

        return back()->with('message','Successfully deleted! You can still recover your account or permanently delete it!');
    }

    public function restore(Conta $conta)
    {
        $id = $conta->id;
        $conta_restore = Conta::withTrashed()->where('id', $id);
        $conta_restore->restore();

        return back()->with('message','Successfully recovered!');
    }

    public function delete(Conta $conta){

        return view('privateArea.delete')->withConta($conta);;
    }

    public function destroy(Conta $conta){
        $id = $conta->id;
        $conta_delete = Conta::where('id', $id)->forceDelete();

        return back()->with('message','Successfully delete!');
    }
}
