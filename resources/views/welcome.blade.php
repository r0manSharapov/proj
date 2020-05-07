@extends('layouts.app')
@section('content')

            <div class="text-center">


                        <h1 class="cover-heading" style="margin-top: 50px">Finanças Pessoais</h1>
                        <p class="lead" style="margin-left: 100px; margin-bottom: 50px; margin-right: 100px;">
                            A aplicação web "Finanças Pessoais" tem como principal objetivo ajudar os utilizadores a gerir as suas finanças pessoais.
                            Os utilizadores têm uma área privada, onde poderão registar todos os seus movimentos financeiros (receitas e despesas) organizados por contas, ver um sumário do estado das suas finanças e aceder a informação estatística sobre as suas receitas e despesas.
                        </p>




                        <div class ="container">






                            <h4>Total Utilizadores Registados </h4>
                    <p>{{$totalUtilizadores ?? 0}}</p>

                    <h4>Total de Contas</h4>
                    <p>{{$totalContas ?? 0}}</p>

                    <h4 >Total de Movimentos </h4>
                    <p>{{$totalMovimentos ?? 0}}</p>



                </div>
                        </div>



    </div>
@endsection
