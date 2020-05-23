@extends('layouts.app')
@section('title','Movimentos')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl">
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
                        <!-- para procurar user por mail para partilhar conta
                        <div class="col">
                            <div class="input-group"  style="z-index: 1;">
                                <input type="text" name="search" class="form-control" placeholder="Share with... (email)">
                                
                                <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
                            </div>
                        </div>
                        -->
                    </div>
                    @if(session()->get('message'))
                        <div class="alert alert-success" role="alert">
                            <a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a>
                            <strong>SUCCESS:</strong>&nbsp;{{session()->get('message')}}
                        </div>
                    @endif
                    <div class="card-body">
                        <form action="{{route('accountDetailsSearch', ['conta' => $conta,'user'=>$user])}}" method="get" class="form-group">
                            <div class="input-group"  style="z-index: 1;">
                                <input type="text" name="search" class="form-control" placeholder="Search in movements list">
                                
                                <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
                            </div>
                            <br>
                            <div class="d-inline">
                                    <select class="selectpicker" data-live-search="true" name="movementType" style="width:200px;">
                                        <option value="0">Movement type</option>
                                        <option value="1">Receita</option>
                                        <option value="2">Despesa</option>
                                    </select>
                                </div>
                        </form>
                        <table class="table">
                            <thead class="thead-dark" >
                            <tr style="text-align:center">
                                <th scope="col">Date</th>
                                <th scope="col">Value</th>
                                <th scope="col" >Starting Balance</th>
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
                                <tr style="text-align:center;">
                                    <td>{{ $movimento->data}}</td>
                                    <td>     {{ $movimento->valor}}€</td>
                                    <td>     {{ $movimento->saldo_inicial}}€</td>
                                    <td>     {{ $movimento->saldo_final}}€</td>

                                    <td>     {{ $movimento->categoria ? $movimento->categoria->nome : '-'  }}</td>

                                    <td>
                                        @if($movimento->tipo == 'D')
                                            Despesa
                                        @else
                                            Receita
                                        @endif
                                    </td>
                                    <td>
                                        <a  class="btn btn-dark" href="{{route('viewUpdateMovement',[ 'user'=>$user,'conta' => $conta,'movimento'=>$movimento])}}">Update</a>
                                    </td>
                                    <td>
                                        <a class="btn btn-danger" data-toggle="modal" href="#myModal{{$movimento->id}}">Delete</a>
                                    </td>
                                    <td>
                                        <a class="btn btn-success" href="{{ route('accountDetailsMoreInfo', ['movimento' => $movimento->id])}}">More Info</a>
                                    </td>
                                </tr>
                                <div id="myModal{{$movimento->id}}" class="modal fade">
                                    <div class="modal-dialog modal-confirm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Are you sure?</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Do you really want to delete this movement? This process cannot be undone.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                                                <form action="{{ route('deleteMovement', ['movimento_id' => $movimento->id])}}" method="post" >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button   type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                            </tbody>

                        </table>

                        <a  class="btn btn-secondary" href="{{route('viewAddMovement',[ 'user'=>$user,'conta' => $conta])}}">AddMovement</a>

                    </div>
                    {{$movimentos->withQueryString()->links()}}
                </div>
            </div>
        </div>
    </div>




@endsection
