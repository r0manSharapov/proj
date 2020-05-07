<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Finanças Pessoais</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 54px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .estatisticas{
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;


            }

            .p_estatisticas{

                background-color: #cce6ff;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

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
        </div>
    </body>
</html>
