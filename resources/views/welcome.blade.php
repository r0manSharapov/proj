@extends('layouts.app')
@section('title','Personal Finances')
@section('content')

<div class="text-center">
        <h1 class="cover-heading" style="margin-top: 50px">Personal Finances</h1>
        <p class="lead" style="margin-left: 100px; margin-bottom: 50px; margin-right: 100px;">
        The "Personal Finances" web application aims to help users manage their personal finances. 
        Users have a private area, where they can record all their financial movements (income and expenses) 
        organized by accounts, see a summary of the status of their finances and access statistical information 
        about their income and expenses.   </p>

        <div class ="container">
            <h4>Total Registered Users </h4>
            <p>{{$totalUtilizadores ?? 0}}</p>

            <h4>Total Accounts</h4>
            <p>{{$totalContas ?? 0}}</p>

            <h4 >Total Movements </h4>
            <p>{{$totalMovimentos ?? 0}}</p>
        </div>
</div>
@endsection
