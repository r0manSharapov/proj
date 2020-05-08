
@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-4" >
            <h1>My First Bootstrap Page</h1>
            <img src="{{Auth::user()->foto != null ? asset('storage/fotos/' . Auth::user()->foto) : asset('storage/fotos/user_default.png')}}" class="rounded-circle" width="250" height="250">

            <form class="form-inline" method="POST" action="{{ route('home')  }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <div class="col-md-6">
                        <input id="foto" type="file" class="form-control @error('foto') is-invalid @enderror" name="foto">

                        @error('foto')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <button type="submit" class="btn btn-success">
                            {{ __('Save Photo') }}
                        </button>

                    </div>
                </div>
            </form>
        </div>
        <div class="col-sm-8">
            <h1>My First Text</h1>
        </div>
    </div>
</div>
@endsection
