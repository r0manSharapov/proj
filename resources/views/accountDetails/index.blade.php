@extends('layouts.app')
@section('title','Movimentos')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div>
                <div class="card">
                    <div class="card-header">

                        <h2>Details of account: {{$conta->nome}}</h2>
                        <p>Description: {{$conta->descricao}}</p>
                        <p>Starting Balance: {{$conta->saldo_abertura}}€</p>
                        <p>Current Balance: {{$conta->saldo_atual}}€</p>

                    </div>
                    <div class="card-body">
                        <form action="{{route('accountDetailsSearch', ['conta' => $conta])}}" method="get" class="form-group">
                            @csrf
                            <div class="input-group"  style="z-index: 1;">
                                <input type="text" name="search" class="form-control" placeholder="Search for a data...">

                            </div>
                            <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
                        </form>
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Value</th>
                                <th scope="col">Starting Balance</th>
                                <th scope="col">Current Balance</th>
                                <th scope="col">Category</th>
                                <th scope="col">Type</th>

                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($movimentos as $movimento)
                                <tr>
                                    <td>     {{ $movimento->data}}</td>
                                    <td>     {{ $movimento->valor}}€</td>
                                    <td>     {{ $movimento->saldo_inicial}}€</td>
                                    <td>     {{ $movimento->saldo_final}}€</td>
                                    <td>     {{ $movimento->categoria_id}}</td>
                                    <td>
                                        @if($movimento->tipo == 'D')
                                            Despesa
                                        @else
                                            Receita
                                        @endif
                                    </td>
                                    <td><button type="button" class="btn btn-dark">Update</button></td>
                                    <td><button type="button" class="btn btn-danger">Delete</button> </td>
                                </tr>
                            @endforeach


                            </tbody>

                        </table>

                        <a  class="btn btn-secondary" href="{{url('#')}}">AddMovement</a>

                    </div>
                    {{$movimentos->withQueryString()->links()}}
                </div>
            </div>
        </div>
    </div>




@endsection
