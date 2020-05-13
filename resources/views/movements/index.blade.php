@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                    @foreach($movimentos as $movimento)
                        <h2>{{ $movimento->conta_id}}</h2> 
                    @endforeach

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

                                {{--@if($movimento->conta_id == 5 )--}}
                                    {{--<tr>--}}
                                        {{--<td>     {{ $movimento->data}}</td>--}}
                                        {{--<td>     {{ $movimento->valor}}€</td>--}}
                                        {{--<td>     {{ $movimento->tipo}}</td>--}}
                                        {{--<td><button type="button" class="btn btn-dark">Update</button></td>--}}
                                        {{--<td><button type="button" class="btn btn-danger">Delete</button> </td>--}}
                                    {{--</tr>--}}
                                {{--@endif--}}



                            </tbody>
                        </table>
                        <a  class="btn btn-secondary" href="{{url('/profile/privateArea/addAccount')}}">AddAccount</a>
                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection
