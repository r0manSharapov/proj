@extends('layouts.app')
@section('title','Users List)
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if(Auth::user()->adm ==1)
                    <h2 style="text-align:center;">Administration</h2>
                @else
                <h2 style="text-align:center;">Users</h2>
                @endif
                <div class="card">
                    <div class="card-header">
                        <div class="col-md-12">
                            <form action="{{route('allUsers')}}" method="get" class="form-group">
                                {{--@csrf--}}
                                <div class="input-group"  style="z-index: 1;">
                                    <input type="text" name="search" class="form-control" placeholder="Search for a user...">

                                        
                                        <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
                                </div>
                                <br>
                                @if(Auth::user()->adm ==1)
                                            <div class="d-inline">
                                                Blocked: <input type="checkbox" id="myCheck" value="1" name="blocked">
                                            </div>

                                            <div class="d-inline">
                                                <select class="default-select" name="userType" style="width:200px;">
                                                    <option value="0">User type</option>
                                                    <option value="1">Admin</option>
                                                    <option value="2">User</option>
                                                </select>
                                            </div>
                                        @endif
                            </form>

                        </div>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <ul class="list-group " id="myList">

                        @foreach($allUsers as $user)
                            <a href="{{ url('profile',$user->id) }}" class="list-group-item list-group-item-action">
                                <div class="d-inline " style="margin-right: 20px;">
                                    <img
                                        src="{{$user->foto != null ? asset('storage/fotos/' . $user->foto) : asset('storage/fotos/user_default.png')}}"
                                        class="rounded-circle" width="55" height="60">
                                </div>
                                <div class="d-inline-block">
                                    <span class="d-block" style="font-size: medium; font-weight: bold; ">
                                        {{$user->name}}
                                    </span>
                                    <span class="d-block">
                                        {{$user->email}}
                                    </span>

                                    @if(Auth::user()->adm ==1) <!-- se for adm-->
                                        @if($user->adm)
                                            <label class="badge badge-success">Admin</label>
                                        @else
                                            <label class="badge badge-primary">User</label>
                                        @endif

                                        @if($user->bloqueado)
                                            <label class="badge badge-danger">Blocked</label>
                                        @endif
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </ul>
                    {{$allUsers->withQueryString()->links()}}

                </div>
            </div>
        </div>
    </div>


@endsection

