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
                        @if(Route::currentRouteName()=='viewAddAccount')
                        <h2>Add Account</h2>
                        @elseif(Route::currentRouteName()=='viewUpdateAccount')
                            <h2>Update Account</h2>

                        @endif
                    </div>
                    <div class="card-body">

                        @if(Route::currentRouteName()=='viewAddAccount')
                        <form action="{{route('addAccount',['user' => $user])}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label >Name</label>
                                <input  id="name" name= "name"  value="{{ old('name') }}" type="text" class="form-control"  @error('name') is-invalid @enderror  >

                            </div>
                            @error('name')
                            <span class="invalid-feedback" role="alert">

                                        <strong>
                                           {{$message}}

                                        </strong>
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

                        @elseif(Route::currentRouteName()=='viewUpdateAccount')
                                <form action="{{route('updateAccount',['user' => $user,'conta'=>$conta])}}" method="post">

                                    @csrf
                                    <div class="form-group">
                                        <label >Name</label>
                                        <input  id="name" name= "name"  value="{{ $conta->nome }}" type="text" class="form-control"  @error('name') is-invalid @enderror  >

                                    </div>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">

                                        <strong>
                                           {{$message}}

                                        </strong>
                                    </span>
                                    @enderror

                                    <div class="form-group" >
                                        <label >Starting Balance</label>

                                        <input id="startBalance" style="width: 200px"  name= "startBalance"  value="{{ $conta->saldo_abertura}}"type="txt" class="form-control" @error('startBalance') is-invalid @enderror >

                                    </div>
                                    @error('startBalance')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                    <div class="form-group" >
                                        <label >Current Balance</label>

                                        <input id="currentBalance" style="width: 200px"  name= "startBalance"  value="{{ $conta->saldo_atual}}"type="txt" class="form-control" @error('currentBalance') is-invalid @enderror >

                                    </div>
                                    @error('currentBalance')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                    <div class="form-group" >
                                        <label >Description (optional) </label>
                                        <input  id="description" name= "description" value="{{$conta->descricao}}" style="height: 200px" type="txt" class="form-control">
                                    </div>



                                    <input type="submit" class="btn btn-secondary" value="Submit">



                                </form>


                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
