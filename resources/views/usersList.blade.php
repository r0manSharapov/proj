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
                                <div class="input-group"  style="z-index: 1;">
                                    <input type="search" name="search" class="form-control"
                                           placeholder="Search for a user...">
                                    <span class="input-group-prepend"><button type="submit"
                                                                              class="btn btn-primary">{{ __('Search') }}</button>
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

                    <ul class="list-group " id="myList">

                        @foreach($allUsers as $user)
                            <a href="{{ route('home') }}" class="list-group-item list-group-item-action">
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


                        @endforeach
                    </ul>
                    {{$allUsers->appends(['search'=>$search])->links() }}

                </div>
            </div>
        </div>
    </div>


@endsection

