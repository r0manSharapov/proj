@extends('layouts.app')
@section('title','Financial Statistics')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Account Statistics</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Movements Statistics</a>
                            </li>

                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div style=" padding:50px ">
                                    <div class="card bg-info" >
                                        <div class="card-body text-center">
                                            <p class="card-text" style="color: white">TOTAL BALANCE: {{$saldoTotal}}€</p>
                                        </div>
                                    </div>

                                    <div style="padding-top: 20px">
                                    {!! $relativeWeightChart->container() !!}
                                    </div>

                                </div>

                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">


                            </div>

                        </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!--

<div style="padding: 100px">

    <div class="row" style="width: 70rem;">

        <div class="col-sm-6">
            <div  class="card border-info mb-3">
                <div class="card-header">
                    <h3>Account's relative weight</h3>
                </div>
                <div class="card-body">
                 <div class="container">
                      <div class="row">

                                        {!! $relativeWeightChart->container() !!}

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card text-white bg-dark mb-3">
                <div class="card-header">
                    <h3>Total Balance</h3>
                </div>
                <div class="card-body">
                    <h4 class="card-text">{{$saldoTotal}}€</h4>

                </div>
            </div>
        </div>
    </div>


<div class="row" style="width: 70rem; padding-top: 10px">
    <div class="col-sm-6">
        <div class="card border-info mb-3">
            <div class="card-header">
                <h3>Movements Statistics</h3>
            </div>
            <div class="card-body">

                <div class="container">

                    <div class="row">





                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card border-info mb-3">
            <div class="card-header">

            </div>
            <div class="card-body">
                <div class="container">

                    <div class="row">





                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div> -->
{{-- ChartScript --}}
@if($relativeWeightChart)
    {!! $relativeWeightChart->script() !!}
@endif

@endsection
