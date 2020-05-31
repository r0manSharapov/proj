@extends('layouts.app')
@section('title',$user->name)
@section('content')
<div class="container-fluid">
<h1 style="text-align:center;padding-bottom:20px;">Profile</h1>
    @if(session()->get('message'))
        <div class="alert alert-success" role="alert">
            <a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a>
            <strong>SUCCESS:</strong>&nbsp;{{session()->get('message')}}
        </div>
    @endif


    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-sm-4" >
                    <p style="text-align:center"><img src="{{$user->foto != null ? asset('storage/fotos/' . $user->foto) : asset('storage/fotos/default_image.jpg')}}" class="rounded-circle" width="250" height="250" alt="Profile picture"></p>

                    @if ($user->id == Auth::id())
                        <form method="POST" action="{{ route('store') }}" enctype="multipart/form-data">
                        @csrf
                            <div class="row">
                                <div style="text-align:center;"class="col">
                                    <input id="foto" type="file" class="form-control @error('foto') is-invalid @enderror" name="foto">

                                    @error('foto')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div style="text-align:center;" class="col">
                                    <button type="submit" class="btn btn-success">
                                        {{ __('Save Photo') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    @else
                        <div style="text-align:center;">
                            @if($user->adm)
                                <label class="badge badge-success">Admin</label>
                            @else
                                <label class="badge badge-primary">User</label>
                            @endif
                        </div>    
                    @endif
                        <br>
                        <h4 style="text-align:center;" ><strong>{{$user->name}}</strong></h4>
                        <h5 style="text-align:center;"><strong>E-mail:</strong> {{$user->email}}</h5>

                    @if (!($user->id == Auth::id())) <!-- se o user n for o autenticado -->
                        @if(Auth::user()->adm ==1) <!-- se for admin -->
                            <form method="post" action="{{ route('change', ['id' => $user->id]) }}"> 
                                @csrf
                                <div class="row">
                                    <div class="col-sm-12 text-center">
                                        @if($user->bloqueado)
                                            <h3><button value="{{$user->id}}" class="btn btn-warning" type="submit" name="unblock"><strong>Unblock</strong></button></h3>
                                        @else
                                            <h3><button value="{{$user->id}}" name="block" type="submit" class="btn btn-danger">Block</button></h3>
                                        @endif
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Change type of user
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                @if($user->adm)
                                                    <button value="{{$user->id}}" name="user" class="dropdown-item" type="submit">User</button>
                                                @else
                                                    <button value="{{$user->id}}" name="admin" class="dropdown-item" type="submit">Admin</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>    
                    @endif 
                </div>
                
                
                    <div class="col-sm-7" >
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h2>Accounts shared</h2>
                                        </div>
                                        <div class="card-body">
                                            <table class="table">
                                                <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Balance</th>
                                                    <th scope="col"></th>
                                                    <th scope="col"></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($contasUser as $conta)
                                                        <tr>
                                                            <td> {{ $conta->nome}} </td>
                                                            <td> {{ $conta->saldo_atual}} </td>
                                                            <td>
                                                                <form action="{{ route('updateUser', ['conta_id' => $conta->id])}}" method="post" >
                                                                    @csrf
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
                                                                            @if($conta->pivot->so_leitura == 1)
                                                                                Read Only
                                                                            @else
                                                                                Complete
                                                                            @endif
                                                                        </button>
                                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                                            @if($conta->pivot->so_leitura == 1)
                                                                                    <button value="{{$user->id}}" name="complete" class="dropdown-item" type="submit">Complete</button>
                                                                            @else
                                                                                    <button value="{{$user->id}}" name="read" class="dropdown-item" type="submit">Read Only</button>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </td>
                                                            <td>
                                                                <form action="{{ route('removeUser', ['conta_id' => $conta->id])}}" method="post" >
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button value="{{$user->id}}" name="delete" class="btn btn-danger" type="submit">Delete</button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div style="text-align:right;">
                            <form method="post" action="{{ route('shareAccount', ['id' => $user->id]) }}"> 
                            @csrf
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Share Account
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                        @foreach($notUser as $conta)
                                                    <button value="{{$conta->id}}" name="addUser" class="dropdown-item" type="submit">{{$conta->nome}}</option>
                                        @endforeach
                                        @if($notUser->count() == 0)
                                            <div class="dropdown-item" aria-labelledby="dropdownItem">
                                                No more accounts 
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
