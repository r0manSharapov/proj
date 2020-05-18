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
                        @if(Route::currentRouteName()=='viewAddMovement')
                        <h2>Add Movement</h2>


                        @endif
                    </div>
                    <div class="card-body">

                        @if(Route::currentRouteName()=='viewAddMovement')
                        <form action="{{route('addMovement',['user' => $user,'conta'=>$conta])}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label >Date</label>
                                <input  id="data" name= "data"  value="{{ old('data') }}" type="text" class="form-control"  @error('data') is-invalid @enderror  >

                            </div>
                            @error('data')
                            <span class="invalid-feedback" role="alert">

                                        <strong>
                                           {{$message}}

                                        </strong>
                                    </span>
                            @enderror

                            <div class="form-group" >
                                <label >Value</label>

                                <input id="valor" style="width: 200px"  name= "valor"  value="{{ old('valor') }}"type="txt" class="form-control" @error('valor') is-invalid @enderror >

                            </div>
                            @error('valor')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror

                            <div class="form-group" >
                                <label >Movement Type: </label>
                                <select class="form-control" name="tipoMovimemto" >
                                    <option value="D">Expense</option>
                                    <option value="R">Revenue</option>
                                </select>
                            </div>

                                <div class="form-group">
                                    <label >Category (optional) </label>

                                    <select class="form-control" name="categoria" >
                                        <option value={{null}}>No category</option>
                                        @foreach($categorias as $cat)
                                            <option value="{{$cat->id}}">{{$cat->nome}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            @error('categoria')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror

                            <div class="form-group" >
                                <label >Description (optional) </label>
                                <input  id="descricao" name= "descricao" value="{{old('descricao') }}" style="height: 200px" type="txt" class="form-control">
                            </div>

                            @error('descricao')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror





                            <input type="submit" class="btn btn-secondary" value="Submit">



                        </form>

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
