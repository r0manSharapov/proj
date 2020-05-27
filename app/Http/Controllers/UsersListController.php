<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

use App\User;
use App\Conta;
use App\Autorizacoes_conta;


class UsersListController extends Controller
{
    public function index(){
        $users= User::paginate(5);
        return view('usersList')->withAllUsers($users);
    }

    public function search(Request $request)
    {
        $search = $request->get('search');
        $usersSearch = User::where(function ($query) use($search) {
            $query->where('name','like','%'.$search.'%')
                ->orwhere('email','like','%'.$search.'%');
        });

        $is_adm =  Auth::user()->adm;

        if($is_adm == 1)
        {
            $userType = $request->get('userType');
            if($userType==1){

                $usersSearch= $usersSearch->where('adm',1);

            }
            if($userType==2){
                $usersSearch=$usersSearch->where('adm',0);
            }

            $blocked = $request->get('blocked');
            if($blocked){
                $usersSearch=$usersSearch->where('bloqueado',1);
            }

            return view('usersList')->withAllUsers($usersSearch->paginate(5))
                ->withSearch($search)
                ->withUserType($userType)
                ->withBlocked($blocked);
        }


        return view('usersList')->withAllUsers($usersSearch->paginate(5))
            ->withSearch($search);
    }

    public function show($id)
    {
        $contas = Conta::where('user_id', Auth::id())->get();
        $contasID = Conta::select('id')->where('user_id', Auth::id())->get();
        $user = User::findOrFail($id);
        $autorizacoes = Autorizacoes_conta::where('user_id', $id)->whereIn('conta_id',$contasID)->get();
        $contaID = $autorizacoes->pluck('conta_id');
        $contasShared = Conta::whereIn('id',$contaID)->get();
        //dd($autorizacoes);
        
        return view('profile.index')->withUser($user)->withContas($contas)
            ->withContasShared($contasShared)->withAutorizacoes($autorizacoes);
    }

    public function shareAccount(Request $request, $id){
        $contaID = $request->get('addUser');

        if($contaID){
            Autorizacoes_conta::create([
                'user_id'=> $id,
                'conta_id'=>$contaID,
                'so_leitura'=> 1,
                'deleted_at'=>null
            ])->save(); 

            return back()->with('message',"You shared your account successfully!");
        }

        return back();
    }
}
