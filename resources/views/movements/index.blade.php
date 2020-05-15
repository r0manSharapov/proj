@extends('layouts.app')
@section('title','Movimentos')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">

                        <h2>{{$conta->nome}}</h2>

                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Value</th>
                                <th scope="col">Type</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($movimentos as $movimento)
                                <tr>
                                    <td>     {{ $movimento->data}}</td>
                                    <td>     {{ $movimento->valor}}€</td>
                                    <td>     {{ $movimento->tipo}}</td>
                                    <td><button type="button" class="btn btn-dark">Update</button></td>
                                    <td><button type="button" class="btn btn-danger">Delete</button> </td>
                                </tr>
                            @endforeach


                            </tbody>

                        </table>

                        <a  class="btn btn-secondary" href="{{url('/profile/privateArea/addAccount')}}">AddAccount</a>

                    </div>
                    {{$movimentos->withQueryString()->links()}}
                </div>
            </div>
        </div>
    </div>




@endsection
