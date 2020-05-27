<?php


namespace App\Http\Controllers;

use App\Charts\Chart;
use App\Charts\ChartStatistics;
use App\Conta;
use App\User;

class StatisticsController
{
    public function index(User $user){

        $contas = Conta::where('user_id',$user->id);
        $saldoTotal=$contas->sum('saldo_atual');

        //CHARTS ->
        $borderColors = [
            "rgba(255, 99, 132, 1.0)",
            "rgba(22,160,133, 1.0)",
            "rgba(255, 205, 86, 1.0)",
            "rgba(51,105,232, 1.0)",
            "rgba(244,67,54, 1.0)",
            "rgba(34,198,246, 1.0)",
            "rgba(153, 102, 255, 1.0)",
            "rgba(255, 159, 64, 1.0)",
            "rgba(233,30,99, 1.0)",
            "rgba(205,220,57, 1.0)"
        ];
        $fillColors = [
            "rgba(255, 99, 132, 0.2)",
            "rgba(22,160,133, 0.2)",
            "rgba(255, 205, 86, 0.2)",
            "rgba(51,105,232, 0.2)",
            "rgba(244,67,54, 0.2)",
            "rgba(34,198,246, 0.2)",
            "rgba(153, 102, 255, 0.2)",
            "rgba(255, 159, 64, 0.2)",
            "rgba(233,30,99, 0.2)",
            "rgba(205,220,57, 0.2)"

        ];

        $usersChart = new ChartStatistics();
        $nomesConta = $contas->pluck('nome')->toArray();

        $relativeWeight = [];
        foreach($contas->get() as $conta){
            $relativeWeight[] = $conta->saldo_atual/$saldoTotal;
        }


        $usersChart->labels($nomesConta);
        $usersChart->dataset('Relative Weight', 'doughnut', $relativeWeight)
        ->color($borderColors)
            ->backgroundcolor($fillColors);
        return view('statistics.index')->with('saldoTotal',$saldoTotal)->withContas($contas->get())
            ->withUsersChart($usersChart);
    }


}
