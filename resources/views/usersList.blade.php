
@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
            <h2 style="text-align:center;">Users</h2>
                <div class="card">
                    <div class="card-header">
                        <div class="col-md-12">
                            <form action="/allUsers" method="get">
                                @csrf
                                <div class="input-group">
                                    <input type="search" name="search" class="form-control" placeholder="Search for a user...">
                                    <span class="input-group-prepend"><button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>    
                                @foreach($allUsers as $user)
                                <tr>
                                    <td><img src="{{$user->foto != null ? asset('storage/fotos/' . $user->foto) : asset('storage/fotos/user_default.png')}}" class="rounded-circle" width="50" height="50"></td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                </tr>
                            </tbody>    
                                @endforeach
                        </table>    
                    {{$allUsers->links() }}

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

