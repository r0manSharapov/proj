@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('User Settings') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('settings') }}">
                            @csrf

                            <div class="form-group row">

                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">

                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value={{ Auth::user()->name }} required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror


                                </div>





                            </div>




                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value={{ Auth::user()->email }} required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="nif" class="col-md-4 col-form-label text-md-right">{{ __('NIF') }}</label>

                                <div class="col-md-6">
                                    <input id="nif" type="text" class="form-control @error('nif') is-invalid @enderror" name="nif" value={{ Auth::user()->NIF }}>

                                    @error('nif')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="telefone" class="col-md-4 col-form-label text-md-right">{{ __('Phone number') }}</label>

                                <div class="col-md-6">
                                    <input id="telefone" type="text" class="form-control @error('telefone') is-invalid @enderror" name="telefone" value={{ Auth::user()->telefone }}>

                                    @error('telefone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="foto" class="col-md-4 col-form-label text-md-right">{{ __('Photo') }}</label>

                                <div class="col-md-6">
                                    <input id="foto" type="file" class="form-control @error('foto') is-invalid @enderror" name="foto" value={{ Auth::user()->foto }}>

                                    @error('foto')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update Settings') }}
                                    </button>




                                <a class="card-link" href="{{ route('change.password') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('change-password-form').submit();">
                                    {{ __('Change Password') }}
                                </a>

                                </div>
                            </div>
                        </form>
                        <form id="change-password-form" action="{{ route('change.password') }}" method="GET" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>




@endsection
