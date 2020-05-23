@extends('layouts.app')
@section('title','Lista de Utilizadores')
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
                            <form action="{{route('addAccountToUser')}}" method="get" class="form-group">
                                <div class="input-group"  style="z-index: 1;">
                                    <input type="text" name="search" class="form-control" placeholder="Search for a user...">


                                    <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
                                </div>
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
                            <a href="#myModal{{$user->id}}" class="list-group-item list-group-item-action" data-toggle="modal">
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

                                </div>
                            </a>

                            <div id="myModal{{$user->id}}" class="modal fade">
                                <div class="modal-dialog modal-confirm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">You will add this user to account X</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                        </div>
                                        <div class="modal-footer">

                                            <div>
                                                Read Only: <input type="checkbox" id="myCheck" value="1" name="ronly">
                                            </div>
                                            <div>
                                                All what you want: <input type="checkbox" id="myCheck" value="0" name="allYouWant">
                                            </div>
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>

                                            <form action="#" method="get" >



                                                <button type="submit" class="btn btn-danger">Add</button>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </ul>
                    {{$allUsers->withQueryString()->links()}}

                </div>
            </div>
        </div>
    </div>


@endsection

