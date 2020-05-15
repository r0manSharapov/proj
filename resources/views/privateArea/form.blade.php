@extends('layouts.app')
@section('content')
    @if(session()->get('message'))
        <div class="alert alert-success" role="alert">
            <a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a>
            <strong>SUCCESS:</strong>&nbsp;{{session()->get('message')}}
        </div>
    @endif
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2>Add Account</h2>

                    </div>
                    <div class="card-body">

                        <form action="{{route('addAccount',['user' => $user])}}" method="post">
                            @csrf
                                <div class="form-group">
                                    <label >Name</label>
                                    <input  id="name" name= "name"  value="{{ old('name') }}" type="text" class="form-control"  @error('name') is-invalid @enderror  >

                                </div>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                                <div class="form-group" >
                                    <label >Starting Balance</label>

                                    <input id="startBalance" style="width: 200px"  name= "startBalance"  value="{{ old('startBalance') }}"type="txt" class="form-control" @error('startBalance') is-invalid @enderror >

                                </div>
                            @error('startBalance')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror

                            <div class="form-group" >
                                <label >Description (optional) </label>
                                <input  id="description" name= "description" value="{{old('description')}}" style="height: 200px" type="txt" class="form-control">
                            </div>



                            <input type="submit" class="btn btn-secondary" value="Submit">






                          </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
