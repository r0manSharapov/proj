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
                        <p style="text-align:center"><img src="{{$movimento->image_doc != null ? route('accountDetailsMoreInfo', ['user'=>$user,'conta' => $conta, 'movement' => $movimento]) : "No foto for this movement"}}" alt="Document image"></p>
                    </div>

                </div>
            </div>
        </div>
    </div>



@endsection
