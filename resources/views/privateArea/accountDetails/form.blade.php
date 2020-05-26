@extends('layouts.app')
@section('title','Movement')
@section('content')
    @if(session()->get('message'))
        <div class="alert alert-success" role="alert">
            <a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a>
            <strong>SUCCESS:</strong>&nbsp;{{session()->get('message')}}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger" role="alert">
            {{session('error')}}
        </div>
    @endif

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        @if(Route::currentRouteName()=='viewAddMovement')
                        <h2>Add Movement</h2>
                            @elseif(Route::currentRouteName()=='viewUpdateMovement')
                            <h2>Update Movement</h2>
                        @endif
                    </div>
                    <div class="card-body">

                        @if(Route::currentRouteName()=='viewAddMovement')
                        <form action="{{route('addMovement',['user' => $user,'conta'=>$conta])}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label >Date</label>
                                <input  id="data" name= "data"  value="{{ old('data') }}" type="text" class="form-control  @error('data') is-invalid @enderror " >

                                @error('data')
                                <span class="invalid-feedback" role="alert">
                                        <strong>
                                           {{$message}}
                                        </strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="form-group" >
                                <label >Value</label>

                                <input id="valor" style="width: 200px"  name= "valor"  value="{{ old('valor') }}"type="txt" class="form-control @error('valor') is-invalid @enderror" >

                                @error('valor')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="form-group" >
                                <label >Movement Type: </label>
                                <select class="form-control" name="tipoMovimento" >
                                    <option value="D">Expense</option>
                                    <option value="R">Revenue</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label >Category (optional) </label>

                                <select class="form-control" name="categoria_id" >
                                    <option value={{null}}>No category</option>
                                    @foreach($categorias as $cat)
                                        <option value="{{$cat->id}}">{{$cat->nome}}</option>
                                    @endforeach
                                </select>


                                @if(session('error'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong> {{session('error')}}</strong>
                                      </span>
                                @endif

                                </div>

                                <div class="form-group">
                                    <label >Document Image </label>
                                    <input id="imagem_doc" type="file" class="form-control @error('imagem_doc') is-invalid @enderror" name="imagem_doc">

                                    @error('imagem_doc')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>



                                <div class="form-group" >
                                    <label >Description (optional) </label>
                                    <input  id="descricao" name= "descricao" value="{{old('descricao') }}" style="height: 200px" type="txt" class="form-control @error('descricao') is-invalid @enderror">


                                    @error('descricao')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>








                            <input type="submit" class="btn btn-secondary" value="Submit">



                        </form>
                            @elseif(Route::currentRouteName()=='viewUpdateMovement')

                            <form action="{{route('updateMovement',['user' => $user,'conta'=>$conta,'movimento'=>$movimento])}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label >Date</label>
                                    <input  id="data" name= "data"  value="{{ $movimento->data }}" type="text" class="form-control  @error('data') is-invalid @enderror " >

                                    @error('data')
                                    <span class="invalid-feedback" role="alert">

                                        <strong>
                                           {{$message}}

                                        </strong>
                                    </span>
                                    @enderror
                                </div>


                                <div class="form-group" >
                                    <label >Value</label>

                                    <input id="valor" style="width: 200px"  name= "valor"  value="{{ $movimento->valor}}"type="txt" class="form-control @error('valor') is-invalid @enderror" >

                                    @error('valor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>



                                <div class="form-group" >
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" name="alterMovType">
                                        <label >Movement Type: </label>
                                        <select class="form-control" name="tipoMovimento" >
                                            <option value="D">Expense</option>
                                            <option value="R">Revenue</option>
                                        </select>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" name="alterCatType">
                                        <label >Category (optional) </label>


                                        <select class="form-control" name="categoria_id" >
                                            <option value={{null}}>No category</option>
                                            @foreach($categorias as $cat)
                                                <option value="{{$cat->id}}">{{$cat->nome}}</option>
                                            @endforeach
                                        </select>
                                    </div>



                                    @if(session('error'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong> {{session('error')}}</strong>
                                          </span>
                                    @endif

                                </div>

                                <div class="form-group">
                                    <label >Document Image </label>
                                    <input id="imagem_doc" type="file" class="form-control @error('imagem_doc') is-invalid @enderror" name="imagem_doc">

                                    @error('imagem_doc')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group" >
                                    <label >Description (optional) </label>
                                    <input  id="descricao" name= "descricao" value="{{$movimento->descricao}}" style="height: 200px" type="txt" class="form-control @error('descricao') is-invalid @enderror">


                                    @error('descricao')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
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
