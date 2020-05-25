@extends('layouts.app')
@section('title','Financial Statistics')
@section('content')


<div style="padding: 100px">

    <div class="row" style="width: 70rem;">
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
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">

                </div>
                <div class="card-body">
                    <h5 class="card-title">Special title treatment</h5>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>

                </div>
            </div>
        </div>
    </div>


<div class="row" style="width: 70rem; padding-top: 10px">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">

            </div>
            <div class="card-body">
                <h5 class="card-title">Special title treatment</h5>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>

            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">

            </div>
            <div class="card-body">
                <h5 class="card-title">Special title treatment</h5>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>

            </div>
        </div>
    </div>
</div>

</div>


@endsection
