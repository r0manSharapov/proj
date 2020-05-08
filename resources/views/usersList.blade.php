
@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Users List</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @foreach($allUsers as $user)
                                <div class="list-group">

                                    <a href="#" class="list-group-item list-group-item-action">
                                        <img src="{{$user->foto != null ? asset('storage/fotos/' . $user->foto) : asset('storage/fotos/user_default.png')}}" class="rounded-circle" width="50" height="50">
                                        {{$user->name}} |
                                        {{$user->email}}
                                       </a>


                                </div>

                            @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

