@extends('layouts.app')
@section('title','Shared Account')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="card">
                <div class="card-header">
                    <h2>Users with access to <strong> {{$conta->nome}}</strong></h2>
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
                            <th scope="col">Email</th>
                            <th scope="col">Access</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($usersDaConta as $infoUser)
                            <tr>
                                <td> {{ $infoUser->name}} </td>
                                <td> {{ $infoUser->email}} </td>
                                <td>
                                    <form action="{{ route('updateUser', ['conta_id' => $conta->id])}}" method="post" >
                                        @csrf
                                        <div class="dropdown">
                                            <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                @if($infoUser->pivot->so_leitura == 1)
                                                    Read Only
                                                @else
                                                    Complete
                                                @endif
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                @if($infoUser->pivot->so_leitura == 1)
                                                    <button value="{{$infoUser->id}}" name="complete" class="dropdown-item" type="submit">Complete</button>
                                                @else
                                                    <button value="{{$infoUser->id}}" name="read" class="dropdown-item" type="submit">Read Only</button>
                                                @endif
                                            </div>
                                        </div>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route('removeUser', ['conta_id' => $conta->id])}}" method="post" >
                                        @csrf
                                        @method('delete')
                                        <button value="{{$infoUser->id}}" name="delete" class="btn btn-danger" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <a  class="btn btn-primary" href="{{ route('viewAddUser', ['conta_id' => $conta->id])}}" >
                        Add User
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
