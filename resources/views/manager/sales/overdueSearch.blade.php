@extends('layouts.master')

@section('content')
    <div class="container">

        <ol class="breadcrumb">
            <li><a href="/manager">Home</a></li>
            <li><a href="/manager/sales">Customers</a></li>
            <li class="active">Search</li>
        </ol>

        <h3>Search Customers</h3>
        <h5>{{$message}}</h5>

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
            @foreach((\App\Sale::
                where('SaleRef', 'LIKE', "%" . request()->input("saleRef") . "%")
                ->where('AwaitingPayment', '=',  true)
                ->get()) as $sale)

                <tr>
                    <td><a href="/manager/sales/{{$sale->id}}"> {{$sale->SaleRef}}</a></td>
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