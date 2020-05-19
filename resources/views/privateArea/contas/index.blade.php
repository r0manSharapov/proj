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
                                        <form action="{{ route('restore', ['conta_id' => $conta->id])}}" method="post">
                                            @csrf
                                            <td><button value="{{$conta->id}}" name="recover" type="submit" class="btn btn-warning">Recover</button>
                                            </td>
                                        </form>
                                            <td><a class="btn btn-danger" data-toggle="modal" href="#myModal{{$conta->id}}">Permanently Delete</a></td>
                                        <td></td>
                                    @else
                                        <td>{{ $conta->saldo_atual}}€</td>
                                        <td>
                                            <a  class="btn btn-primary" href="{{ route('accountDetails', ['conta' => $conta,'user'=>$user])}}" >
                                                Details
                                            </a>
                                        </td>
                                        <td>
                                            <a  class="btn btn-dark" href="{{route('viewUpdateAccount',['user'=>$user,'conta'=>$conta])}}" >
                                                Update
                                            </a>
                                        </td>
                                        <form name="softdelete" action="{{ route('softDelete', ['conta' => $conta])}}" method="post" >
                                            @csrf
                                            @method('DELETE')
                                            <td><button type="submit" class="btn btn-danger">Delete</button></td>
                                        </form>
                                        </tr>
                                    @endif

                                    <div id="myModal{{$conta->id}}" class="modal fade">
                                        <div class="modal-dialog modal-confirm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Are you sure?</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Do you really want to delete this account permanently? This process cannot be undone.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>

                                                    <form action="{{ route('delete', ['conta_id' => $conta->id])}}" method="post" >

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
                        <a  class="btn btn-secondary"  href="{{route('viewAddAccount',['user'=>$user])}}">Add Account</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
