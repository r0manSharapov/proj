@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="card">
                <div class="card-header">
                    <h2>User who has access to account </h2>
                    {{--{{$conta->nome}}--}}
                </div>

                <div class="card-body">
                    <table class="table">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Change access to account</th>
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
                                                    Read
                                                @else
                                                    Complete
                                                @endif
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                @if($infoUser->pivot->so_leitura == 0)
                                                <button value="{{$infoUser->id}}" name="read" class="dropdown-item" type="submit">Read</button>
                                                @else
                                                <button value="{{$infoUser->id}}" name="complete" class="dropdown-item" type="submit">Complete</button>
                                                @endif

                                            </div>
                                        </div>
                                    </form>
                                </td>
                                <td>
                                    <a  class="btn btn-danger" href="#" >
                                        Delete
                                    </a>
                                </td>

                            </tr>



                        @endforeach
                        </tbody>
                    </table>
                    <a  class="btn btn-primary" data-toggle="modal" href="#myModalAdd{{$conta->id}}" >
                        Add User
                    </a>

                    <div id="myModalAdd{{$conta->id}}" class="modal fade">
                        <div class="modal-dialog modal-confirm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Share account with...</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                </div>
                                @if(session('error'))
                                    <div class="alert alert-danger" role="alert">
                                        {{session('error')}}
                                    </div>
                                @endif
                                <form action="{{ route('addUser', ['conta_id' => $conta->id])}}" method="post" >
                                    @csrf
                                    <div class="modal-body">
                                        <input id="email" name="email" value="{{ old('email') }}" class="form-control" type="text" placeholder="Search user by email">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-success">Add</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
