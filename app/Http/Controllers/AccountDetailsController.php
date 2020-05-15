<?php

namespace App\Http\Controllers;


use App\Conta;
use App\Movimento;
use Illuminate\Http\Request;


class AccountDetailsController extends Controller
{
    public function index(Conta $conta ){

        $movimentos = Movimento::where('conta_id', $conta->id)
                    ->orderBy('data', 'desc')
                    ->paginate(6);


        return view('accountDetails.index')->withMovimentos($movimentos)
                                           ->withConta($conta);
    }

    public function search(Request $request, Conta $conta)
    {
        $search = $request->get('search');
        $movementsSearch = Movimento::where('data','like','%'.$search.'%')->where('conta_id', $conta->id);




//        if($is_adm == 1)
//        {
//            $userType = $request->get('userType');
//            if($userType==1){
//
//                $usersSearch= $usersSearch->where('adm',1);
//
//            }
//            if($userType==2){
//                $usersSearch=$usersSearch->where('adm',0);
//            }
//
//            $blocked = $request->get('blocked');
//            if($blocked){
//                $usersSearch=$usersSearch->where('bloqueado',1);
//            }
//
//
//
//            return view('usersList')->withAllUsers($usersSearch->paginate(6))
//                ->withSearch($search)
//                ->withUserType($userType)
//                ->withBlocked($blocked);
//        }

        return view('accountDetails.index')->withMovimentos($movementsSearch->paginate(6))
            ->withSearch($search)
            ->withConta($conta);
    }
}
