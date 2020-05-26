@extends('layouts.app')
@section('title','Add User to Account')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                            <h2>Add User</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('addUser', ['conta_id' => $conta])}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label >Email</label>
                                <input name= "email" value="{{ old('email') }}" type="text" class="form-control  @error('email') is-invalid @enderror">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>

                            <div class="form-group" >
                            <label >Type of Access</label>
                                <select class="form-control" name="type_access" >
                                    <option value="1">Read Only</option>
                                    <option value="0">Complete</option>
                                </select>

                                @if(session('error'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong> {{session('error')}}</strong>
                                      </span>
                                @endif
                            </div>
                            <input type="submit" class="btn btn-primary" value="Submit">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection