
@extends('layouts.app')
@section('content')
<div class="container-fluid">
<h1 style="text-align:center;padding-bottom:40px;">Profile</h1>
    @if(session()->get('message'))
        <div class="alert alert-success" role="alert">
            <a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a>
            <strong>SUCCESS:</strong>&nbsp;{{session()->get('message')}}
        </div>
    @endif
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-sm-4" >
                    <p style="text-align:left"><img src="{{Auth::user()->foto != null ? asset('storage/fotos/' . Auth::user()->foto) : asset('storage/fotos/user_default.png')}}" class="rounded-circle" width="250" height="250" alt="Profile picture"></p>

                    <form method="POST" action="{{ route('home')  }}" enctype="multipart/form-data">
                    @csrf
                    
                        <div class="row">
                            <div class="col">
                                <input id="foto" type="file" class="form-control @error('foto') is-invalid @enderror" name="foto">

                                @error('foto')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="col">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Save Photo') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                
                    <div class="col">
                        <h3><strong>{{Auth::user()->name}}</strong></h3>
                        <h4><strong>E-mail:</strong> {{Auth::user()->email}}</h4>
                        <h4><strong>Phone Number:</strong> {{Auth::user()->telefone}}</h4>
                        <h4><strong>NIF:</strong> {{Auth::user()->NIF}}</h4>
                    </div>
            

        <ul class="nav nav-tabs">
                            <div class="container" style="border-style: outset">
                            <h2 style="text-align:center;padding-top:20px;"> Menu </h2>
                                <div class="col" >
                                        <li class="nav-item active"><a class="nav-link" href="#home">Financial Information</a></li>
                                        <li class="nav-item active"><a class="nav-link" href="#news">News</a></li>
                                        <li class="nav-item active"><a class="nav-link" href="#contact">Contact</a></li>
                                        <li class="nav-item active"><a class="nav-link" href="#about">About</a></li>

                                        <li class="nav-item active">
                                            <a class="nav-link" href="{{ route('allUsers') }}">{{ __('Users List') }}</a>
                                        </li>
                                </div>
                            </div>
                        </ul>
                        </div>
                        </div>
        </div>
</div>
@endsection
