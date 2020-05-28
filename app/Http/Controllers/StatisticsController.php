<?php


namespace App\Http\Controllers;

use App\Categoria;
use App\Charts\Chart;
use App\Charts\ChartStatistics;
use App\Conta;
use App\Movimento;
use App\User;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

use Illuminate\Http\Request;

class StatisticsController
{
    public function index(User $user){

        $contas = Conta::where('user_id',$user->id);
        $saldoTotal=$contas->sum('saldo_atual');


        $movimentos= Movimento::whereIn('conta_id',$contas->get('id'))->get();
        $totalBalance[0]= $movimentos->where('tipo','R')->sum('valor');
        $totalBalance[1]= $movimentos->where('tipo','D')->sum('valor');
       //moves chart
        $movementsChart = $this->fillChart(['Revenues','Expenses'],$totalBalance,'total value','bar');


        return view('statistics.index')
            ->withUser($user)
            ->withSaldoTotal($saldoTotal)
            ->withContas($contas->get())
            ->withMovementsChart($movementsChart);
    }

    private  function getCreatedAtAttribute($value)
    {
        $date = Carbon::parse($value);
        return $date->format('Y-m-d');
    }


    public function search(User $user,Request $request)
    {

        $contas = Conta::where('user_id',$user->id);
        $saldoTotal=$contas->sum('saldo_atual');

        $request->validate( [
            'dataInicio'=>['date','nullable'],
            'dataFim'=>['date','nullable'],
        ]);

        $dataFim = $request->get('dataFim');
        $dataInicio = $request->get('dataInicio');


        $movimentos= Movimento::
        whereIn('conta_id',$contas->get('id'));

        if($dataInicio==null ){
            $dataInicio= $movimentos->min('data');

        }else{
            $dataInicio = $this->getCreatedAtAttribute($request->get('dataInicio'));
        }
        if($dataFim==null){
            $dataFim=$movimentos->max('data');
        }else{
            $dataFim = $this->getCreatedAtAttribute($request->get('dataFim'));

        }

        $categoria = $request->get('categoria');


        $movimentos=$movimentos
            ->whereBetween('data',[$dataInicio,$dataFim])
            ->get();


        if($categoria) {

            $nomesCategoria = Categoria::pluck('nome')->toArray();

            $i=0;

            foreach ($nomesCategoria as $nome){
                $values[] = $movimentos->where('categoria_id',$i)->sum('valor');
                $i++;
            }
            $nomesCategoria[$i]='Not classified';
            $values[$i]=$movimentos->where('categoria_id',null)->sum('valor');
            //moves chart
            $movementsChart = $this->fillChart($nomesCategoria,$values,'total value','line');


        }else{


            $totalBalance[0]= $movimentos->where('tipo','R')->sum('valor');
            $totalBalance[1]= $movimentos->where('tipo','D')->sum('valor');
            //moves chart
            $movementsChart = $this->fillChart(['Revenues','Expenses'],$totalBalance,'total value','bar');

        }




        return view('statistics.index')
            ->withUser($user)
            ->withSaldoTotal($saldoTotal)
            ->withContas($contas->get())
            ->withMovementsChart($movementsChart);

    }

    public function fillChart($labels, $values,$name,$chartType){

        $chart = new ChartStatistics();

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

        $chart->labels($labels);
        $chart->dataset($name, $chartType, $values)
            ->color($borderColors)
            ->backgroundcolor($fillColors);

        return $chart;
    }

}
