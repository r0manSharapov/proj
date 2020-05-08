
@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Lista de Utilizadores</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @foreach($allUsers as $user)
                                <ul class="list-group">
                                    <li class="list-group-item">{{$user->name}}</li>
                                </ul>

                            @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

