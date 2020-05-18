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

    public function restore(Request $request)
    {
        $id_conta = $request->get('recover');
        $conta_restore = Conta::withTrashed()->where('id', $id_conta);
        $conta_restore->restore();
        $movimentos_restore = Movimento::withTrashed()->where('conta_id', $id_conta);
        $movimentos_restore->restore();

        return back()->with('message','Successfully recovered!');
    }

    public function destroy(Conta $conta)
    {
        dd($conta->id);
        //$id = $conta->id;
       // Autorizacoes_conta::where('conta_id',$id)->forceDelete();
        //Movimento::where('conta_id',$id)->forceDelete();
        //Conta::where('id', $id)->forceDelete();

        return back()->with('message','Successfully deleted!');
    }
}
