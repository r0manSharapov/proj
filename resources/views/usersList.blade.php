
@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                 
                        <input class="form-control" id="myInput" type="text" placeholder="Search for a user..." name="myInput">

                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <ul class="list-group" id="myList">
                        @foreach($allUsers as $user)


                                    <a href="#" class="list-group-item list-group-item-action">
                                        <img src="{{$user->foto != null ? asset('storage/fotos/' . $user->foto) : asset('storage/fotos/user_default.png')}}" class="rounded-circle" width="50" height="50">
                                        {{$user->name}} |
                                        {{$user->email}}
                                       </a>




                            @endforeach
                        </ul>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myList a").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
@endsection

