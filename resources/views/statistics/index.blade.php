@extends('layouts.app')
@section('title','Financial Statistics')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="accounts" role="tabpanel" aria-labelledby="accounts-tab">
                                <div style=" padding:50px ">
                                    <h3 style="padding-bottom: 20px">Account Statistics</h3>
                                    <div class="card text-white bg-dark mb-3" >
                                        <div class="card-body text-center">
                                            <p class="card-text" style="color: white">TOTAL BALANCE: {{$saldoTotal}}€</p>
                                        </div>
                                    </div>

                                    <div style="padding-top: 20px; padding-bottom: 20px">
                                        <table class="table table-hover table-bordered">
                                            <thead>
                                            <tr  >

                                                <th scope="col">Account Name</th>
                                                <th scope="col">Relative Weight (%)</th>

                                            </tr>
                                            </thead>
                                            <tbody>


                                            @foreach($contas as $conta)
                                                <tr  >

                                                    <td>{{$conta->nome}}</td>
                                                    <td>{{round(($conta->saldo_atual/ $saldoTotal)*100,2)}}% </td>
                                                </tr>
                                            @endforeach

                                            </tbody>
                                        </table>

                                    </div>

                                    <div class="dropdown-divider" ></div>
                                    <h3 style="padding-bottom: 20px">Movements Statistics</h3>
                                    <form action="{{route('searchStats',['user'=>$user])}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="card-columns">
                                            <div class="form-group">
                                                <label >Starting Date</label>
                                                <input  id="dataInicio" name= "dataInicio"  value="{{ old('dataInicio') }}" type="text" class="form-control  @error('dataInicio') is-invalid @enderror "  style="width: 150px" >

                                                @error('dataInicio')
                                                <span class="invalid-feedback" role="alert">
                                        <strong>
                                           {{$message}}
                                        </strong>
                                        </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label >End Date</label>
                                                <input  id="dataFim" name= "dataFim"  value="{{ old('dataFim') }}" type="text" class="form-control  @error('dataFim') is-invalid @enderror " style="width: 150px">

                                                @error('dataFim')
                                                <span class="invalid-feedback" role="alert">
                                        <strong>
                                           {{$message}}
                                        </strong>
                                        </span>
                                                @enderror
                                            </div>

                                            <div class="form-check" style="padding-bottom: 10px">
                                                <input class="form-check-input" type="checkbox" value="1" id="defaultCheck1" name="categoria">
                                                <label class="form-check-label" for="defaultCheck1">
                                                    by Category
                                                </label>
                                            </div>

                                            <div class="form-check" style="padding-bottom: 10px">
                                                <input class="form-check-input" type="checkbox" value="1" id="defaultCheck1" name="ano">
                                                <label class="form-check-label" for="defaultCheck1">
                                                    by ano
                                                </label>
                                            </div>

                                            <input type="submit" class="btn btn-primary" value="Search">
                                        </div>
                                    </form>
                                    <div>
                                        {!! $movementsChart->container() !!}
                                    </div>

                                </div>

                            </div>

                        </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    @if($movementsChart)
        {!! $movementsChart->script() !!}
    @endif




@endsection
