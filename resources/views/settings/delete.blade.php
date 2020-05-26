@extends('layouts.app')
@section('title','Delete Account')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            
            <!-- Delete Account -->
            <form class="card user-account" method="POST" action="{{ url('/account/delete') }}">

                {{ csrf_field() }}

                {{ method_field('DELETE') }}

                <div class="card-header rounded-top bg-danger text-light">
                    <h4 class="float-left mb-0 mt-2">Delete Account</h4>
                </div>

                @if(session('error'))
                    <div class="alert alert-danger" role="alert">
                    {{session('error')}}
                    </div>
                @endif

                <div class="card-body">
                    <div class="alert alert-warning">
                        <strong>Caution!</strong> You are about to delete your account.
                    </div>
                    <div class="alert alert-light mb-0">
                        To proceed please enter your password.
                    </div>
                    <div class="form-group row m-0 p-1">
                        <label for="passowrd" class="col-auto col-form-label text-sm-right">Password</label>
                        <div class="col">
                            <input type="password" class="form-control" id="passowrd" name="password">
                        </div>
                    </div>
                </div>

                <div class="card-body border-top">
                    <div class="btn-group float-right text-uppercase" role="group">
                        <a href="{{ route('settings') }}" class="btn btn-secondary btn-100">Cancel</a>
                        <button type="submit" class="btn btn-danger btn-100">Proceed</button>
                    </div>
                </div>

            </form>
            <!-- /Delete Account -->
            
        </div>
    </div>
</div>
@endsection