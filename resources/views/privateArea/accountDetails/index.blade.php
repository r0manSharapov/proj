@extends('layouts.app')
@section('title','Movimentos')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div>
                <div class="card">
                    <div class="card-header">

                        <h2>Details of account: {{$conta->nome}}</h2>
                        <p>Description:
                            @if($conta->descricao == null)
                                No description available
                            @endif
                            {{$conta->descricao}}
                        </p>
                        <p>Starting Balance: {{$conta->saldo_abertura}}€</p>
                        <p>Current Balance: {{$conta->saldo_atual}}€</p>

                    </div>
                    @if(session()->get('message'))
                        <div class="alert alert-success" role="alert">
                            <a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a>
                            <strong>SUCCESS:</strong>&nbsp;{{session()->get('message')}}
                        </div>
                    @endif
                    <div class="card-body">
                        <form action="{{route('accountDetailsSearch', ['conta' => $conta,'user'=>$user])}}" method="get" class="form-group">
                            @csrf
                            <div class="input-group"  style="z-index: 1;">
                                <input type="text" name="search" class="form-control" placeholder="Search in movements list">
                                <div class="d-inline">
                                    <select class="default-select" name="movementType" style="width:200px;">
                                        <option value="0">Movement type</option>
                                        <option value="1">Receita</option>
                                        <option value="2">Despesa</option>
                                    </select>
                                </div>

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
                                    <td>
                                        <a class="btn btn-success" href="{{ route('accountDetailsMoreInfo', ['conta' => $conta,'user'=>$user])}}">More Info</a>
                                    </td>
                                </tr>
                            @endforeach


                            </tbody>

                        </table>

                        <a  class="btn btn-secondary" href="{{route('viewAddMovement',['conta' => $conta,'user'=>$user])}}">AddMovement</a>

                    </div>
                    {{$movimentos->withQueryString()->links()}}
                </div>
            </div>
        </div>
    </div>




@endsection
