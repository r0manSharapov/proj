<?php


namespace App\Http\Controllers;


use App\Conta;
use App\User;

class StatisticsController
{
    public function index(User $user){

        $contas = Conta::where('user_id',$user->id);
        $saldoTotal=$contas->sum('saldo_atual');


        return view('statistics.index')->with('saldoTotal',$saldoTotal)->withContas($contas->get());
    }


}
