@extends('layouts.app')
@section('content')

            <div class="text-center">


                        <h1 class="cover-heading" style="margin-top: 50px">Finanças Pessoais</h1>
                        <p class="lead" style="margin-left: 100px; margin-bottom: 100px; margin-right: 100px;">
                            A aplicação web "Finanças Pessoais" tem como principal objetivo ajudar os utilizadores a gerir as suas finanças pessoais.
                            Os utilizadores têm uma área privada, onde poderão registar todos os seus movimentos financeiros (receitas e despesas) organizados por contas, ver um sumário do estado das suas finanças e aceder a informação estatística sobre as suas receitas e despesas.
                        </p>

                        


                        <div class ="container">

                <h2>Estatísticas</h2>


                <div >

                    <div >Total Utilizadores Registados
                    <p>{{$totalUtilizadores ?? 0}}</p>
                    </div>
                    <div >Total de Contas
                    <p>{{$totalContas ?? 0}}</p>
                    </div>
                    <div >Total de Movimentos
                    <p>{{$totalMovimentos ?? 0}}</p>
                    </div>
                </div>
                        </div>



    </div>
@endsection
