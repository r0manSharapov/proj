@extends('layouts.app')
@section('title','Financial Statistics')
@section('content')


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

                                        {!! $usersChart->container() !!}



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

</div>
{{-- ChartScript --}}
@if($usersChart)
    {!! $usersChart->script() !!}
@endif

@endsection
