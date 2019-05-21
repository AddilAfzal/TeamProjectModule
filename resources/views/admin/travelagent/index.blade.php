@extends('layouts.master')

@section('content')
    <div class="container">

        <ol class="breadcrumb">
            <li><a href="/admin">Home</a></li>
            <li class="active">Travel Agent</li>
        </ol>

        <h3>Travel Agent Details</h3>
        <h5>About the travel agent</h5>
        <a class="btn btn-primary" type="button" href="/admin/travelagent/edit">Edit Details</a>
        @include('layouts.message')

        <h6>Name</h6>
        <p>{{\App\TravelAgent::getName()}}</p>
        <h6>Address</h6>
        <p>
            @foreach(\App\TravelAgent::getAddress() as $line)
                @if($line != '')
                    {{$line}}<br>
                @endif
            @endforeach
        </p>

        <h6>Contact Number</h6>
        <p>{{\App\TravelAgent::getPhoneNumber()}}</p>

        <h6>Local Currency</h6>
        <p>{{\App\Currency::find(\App\TravelAgent::getLocalCurrency())->CurrencyName }}</p>

    </div>
    <hr>
@endsection