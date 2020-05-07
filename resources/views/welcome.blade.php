@extends('layouts.app')
@section('content')
            <div class="content">
                <div class="title m-b-md">
                    Finanças Pessoais
                </div>
                <h2>Apresentação</h2>
                <p>
                    A aplicação web "Finanças Pessoais" tem como principal objetivo ajudar os utilizadores a gerir as suas finanças pessoais.
                    Os utilizadores têm uma área privada, onde poderão registar todos os seus movimentos financeiros (receitas e despesas) organizados por contas, ver um sumário do estado das suas finanças e aceder a informação estatística sobre as suas receitas e despesas.
                </p>
                <h2>Estatísticas</h2>


                <div class="estatisticas">

                    <div class="p_estatisticas">Total Utilizadores Registados
                    <p>{{$totalUtilizadores ?? 0}}</p>
                    </div>
                    <div class="p_estatisticas">Total de Contas
                    <p>{{$totalContas ?? 0}}</p>
                    </div>
                    <div class="p_estatisticas">Total de Movimentos
                    <p>{{$totalMovimentos ?? 0}}</p>
                    </div>
                </div>
            </div>
@endsection
