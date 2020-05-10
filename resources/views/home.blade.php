
@extends('layouts.app')
@section('title',Auth::user()->name)
@section('content')
<div class="container-fluid">
<h1 style="text-align:center;padding-bottom:20px;">Profile</h1>
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
                    <p style="text-align:center"><img src="{{Auth::user()->foto != null ? asset('storage/fotos/' . Auth::user()->foto) : asset('storage/fotos/user_default.png')}}" class="rounded-circle" width="250" height="250" alt="Profile picture"></p>
                    
                    <form method="POST" action="{{ url('home',Auth::user()->id) }}" enctype="multipart/form-data">
                    @csrf
                        <div class="row">
                            <div style="text-align:center;"class="col">
                                <input id="foto" type="file" class="form-control @error('foto') is-invalid @enderror" name="foto">

                                @error('foto')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div style="text-align:center;" class="col">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Save Photo') }}
                                </button>
                            </div>
                        </div>
                    </form>
                

                        <h4 style="text-align:center;" ><strong>{{Auth::user()->name}}</strong></h4>
                        <h5 style="text-align:center;"><strong>E-mail:</strong> {{Auth::user()->email}}</h5>
                        <h5 style="text-align:center;"><strong>Phone Number:</strong> {{Auth::user()->telefone}}</h5>
                        <h5 style="text-align:center;"><strong>NIF:</strong> {{Auth::user()->NIF}}</h5>
                        </div>
                        </div>
                            </div>
                       </div>
                        </div>
        </div>
</div>
@endsection
