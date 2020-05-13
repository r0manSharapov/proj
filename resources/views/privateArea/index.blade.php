@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>My Accounts</h2>
                    </div>
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
                                @if($conta->user_id == Auth::user()->id)
                                    <tr>

                                        <td>     {{ $conta->nome}}</td>
                                        <td>     {{ $conta->saldo_atual}}€</td>
                                        <td>     <a class="btn btn-primary" href="{{url('/profile/'.Auth::id().'/privateArea/movements')}}">Movements List</a></td>
                                        <td><button type="button" class="btn btn-dark">Update</button></td>
                                        <td><button type="button" class="btn btn-danger">Delete</button> </td>
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
