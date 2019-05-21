@extends('layouts.master')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="/advisor">Home</a></li>
            <li class="active">Sales</li>
        </ol>

        <h3>Sales</h3>

        @include('layouts.message')

        <table class="table">

            <thead>
            <th>Sale Reference</th>
            <th>User</th>
            <th>Customer</th>
            <th>Sale Time</th>
            <th>Sale Total</th>
            <th>Awaiting Payment</th>
            </thead>
            @foreach($sales as $sale)

            <tr>
                <td><a href="/advisor/sales/{{$sale->id}}" > {{$sale->SaleRef}}</a> </td>
                <td>{{$sale->advisor->name}}</td>
                <td>{{$sale->customer->Firstname . " " . $sale->customer->Surname}}</td>
                <td>{{$sale->SaleTime}}</td>
                <td>{{$sale->SaleTotal}}</td>

                <td>
                    @if($sale->AwaitingPayment == "1")
                        Yes
                    @else
                        No
                    @endif
                </td>
            </tr>

                @endforeach
        </table>
    </div>

@endsection