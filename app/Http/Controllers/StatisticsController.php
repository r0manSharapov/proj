<?php


namespace App\Http\Controllers;


use App\Conta;
use App\User;

class StatisticsController
{
    public function index(User $user){

        $saldoTotal=$user->contas()->sum('saldo_atual');



        return view('statistics.index')->with('saldoTotal',$saldoTotal);
    }


}
