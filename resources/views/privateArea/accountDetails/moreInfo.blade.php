@extends('layouts.app')
@section('content')


    <div class="container">
        <div class="row justify-content-center">
            <div class="container">

                <div class="card">
                    <div class="card-header">
                        <h2>More Info About selected Movement</h2>
                        <p>Description:
                            @if($movimento->descricao == null)
                                No description available
                            @endif
                            {{$movimento->descricao}}
                        </p>
                    </div>
                    <div class="card-body">
                        <p style="text-align:center">
                            <img src="{{$movimento->imagem_doc ? route('accountDetailsShowPhoto', ['movimento' => $movimento ]) : asset(storage_path('app\docs\default_image.png'))}}"width="250" height="250" alt="Document image">
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>



@endsection
