<?php

namespace App\Http\Controllers;

use App\User;
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

    public function restore($conta_id)
    {
        $conta_restore = Conta::withTrashed()->where('id', $conta_id);
        $conta_restore->restore();
        $movimentos_restore = Movimento::withTrashed()->where('conta_id', $conta_id);
        $movimentos_restore->restore();

        return back()->with('message','Successfully recovered!');
    }

    public function destroy($conta_id)
    {
        Autorizacoes_conta::where('conta_id',$conta_id)->forceDelete();
        Movimento::where('conta_id',$conta_id)->forceDelete();
        Conta::where('id', $conta_id)->forceDelete();

        return back()->with('message','Successfully deleted!');
    }

    /*
    public function share($conta_id){ talvez receba a conta e o user com quem quer partilhar
        $conta = Conta::where('id', $conta_id); encontra a conta
        $conta->users()->attach(auth()->user()); dá a conta a esse user, maybe
    }*/

//    public function showShared(User $user){
//        $contasPartilhadas = Autorizacoes_conta::where('user_id', $user->id)->get();
//        dd($contasPartilhadas);
//        $informacaoContas = Conta::whereIn('id', $contasPartilhadas->conta_id)->with('user')->get();
//
//        return view('privateArea.contas.sharedAccounts')->withInformacaoContas($informacaoContas)->withUser($user);
//
//    }

    public function index(){
        $users= User::paginate(5);
        return view('privateArea.contas.addUserToAccount')->withAllUsers($users);
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $usersSearch = User::where(function ($query) use($search) {
            $query->where('name','like','%'.$search.'%')
                ->orwhere('email','like','%'.$search.'%');
        });

        return view('privateArea.contas.addUserToAccount')->withAllUsers($usersSearch->paginate(5))
            ->withSearch($search);
    }
}
