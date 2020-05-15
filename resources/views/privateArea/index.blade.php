@extends('layouts.app')
@section('title','Contas')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>My Accounts</h2>
                    </div>
                    @if(session()->get('message'))
                        <div class="alert alert-success" role="alert">
                        <a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a>
                        <strong>SUCCESS:</strong>&nbsp;{{session()->get('message')}}
                        </div>
                    @endif

                    <div class="card-body">
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Balance</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($contas as $conta)
                                        <tr>
                                        <td>{{ $conta->nome}}</td>
                                    @if($conta->trashed())
                                        <td style="text-align:center;">-</td>
                                        <form action="{{ route('restore', ['conta' => $conta])}}" method="post">
                                            @csrf 
                                            <td><button type="submit" class="btn btn-warning">Recover</button></td>
                                        </form>
                                            <td><a href="{{ route('conta/delete', ['conta' => $conta])}}" class="btn btn-danger">Permanently Delete</a></td>
                                        <td></td>
                                    @else
                                        <td>{{ $conta->saldo_atual}}€</td>
                                        <td>
                                            <a  class="btn btn-secondary" href="{{ route('movements', ['conta' => $conta])}}" >
                                                Movements List</a>
                                        </td>
                                        <td><button type="button" class="btn btn-dark">Update</button></td>
                                        <form name="softdelete" action="{{ route('softDelete', ['conta' => $conta])}}" method="post" >
                                            @csrf 
                                            @method('DELETE')
                                            <td><button type="submit" class="btn btn-danger">Delete</button></td>
                                        </form>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        <a  class="btn btn-secondary" href="{{url('/profile/privateArea/addAccount')}}">AddAccount</a>
                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection
