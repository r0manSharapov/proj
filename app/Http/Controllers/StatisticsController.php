<?php


namespace App\Http\Controllers;

use App\Categoria;
use Charts;
use App\Charts\Chart;
use App\Charts\ChartStatistics;
use App\Conta;
use App\Movimento;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatisticsController
{
    public function index(User $user){

        $contas = Conta::where('user_id',$user->id);
        $saldoTotal=$contas->sum('saldo_atual');



        $movimentos= Movimento::whereIn('conta_id',$contas->get('id'));
        $totalBalance= $movimentos->groupBy('tipo')->selectRaw('tipo, sum(valor) as sum')->pluck('sum');
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


    /**
     * @param User $user
     * @param Request $request
     * @return mixed
     */
    public function search(User $user, Request $request)
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

        $movimentos=$movimentos->whereBetween('data',[$dataInicio,$dataFim]) ->get(['categoria_id','valor','data','tipo']);

        $categoria = $request->get('categoria');
        $ano= $request->get('ano');

        if($categoria) {



            $values =$movimentos->groupBy('categoria_id')->map(function ($item){
                return $item->sum('valor');
            });

            $labels = Categoria::whereIn('id', $values->keys()->toArray())->pluck('nome')->prepend('Sem Categoria');
            $chartType= 'line';




        }else{
            $labels= ['Revenues','Despenses'];
            $values= $movimentos->groupBy('tipo')->map(function ($item){

                return $item->sum('valor');
            });



            $chartType='bar';
        }

        if($ano && $categoria==null){

            $values= $movimentos->groupBy('tipo')->map(function ($item){

                return $item->mapToGroups(function ($item) {

                    $data = Carbon::parse($item->data)->format('Y');

                    return [$data => $item];
                })->map(function ($item){

                    return $item->sum('valor');
                });
            });

            dd($values);

            $labels=$values->keys();


            $chartType='bar';
        }elseif ($ano && $categoria){


            $values= $movimentos->groupBy('categoria_id')->map(function ($item){

                return $item->mapToGroups(function ($item) {

                    $data = Carbon::parse($item->data)->format('Y');

                    return [$data => $item];
                })->map(function ($item){

                    return $item->sum('valor');
                });
            });

            dd($values);

            $labels=$values->keys();


            $chartType='bar';

        }

        $movementsChart = $this->fillChart($labels, $values->values(), 'total value', $chartType);

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
            ->backgroundcolor($fillColors)
           ;

        return $chart;
    }


}
