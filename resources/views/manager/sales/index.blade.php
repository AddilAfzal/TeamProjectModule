@extends('layouts.master')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="/manager">Home</a></li>
            <li class="active">Sales</li>
        </ol>

        <h3>Sales</h3>

        @include('layouts.message')
        <div class="row">

            <div class="col-md-4">
                <form method="get" action="/manager/sales/search">
                    <div class="input-group">
                        {{csrf_field()}}
                        <input id="saleReference" name="saleReference" type="text" class="form-control"
                               placeholder="Sale Reference" required="">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">Search</button>
                        </span>
                    </div><!-- /input-group -->
                </form>
            </div>
        </div>

        <table class="table">

            <thead>
            <th>Sale Reference</th>
            <th>Blank Number</th>
            <th>User</th>
            <th>Customer</th>
            <th>Sale Time</th>
            <th>Sale Total</th>
            <th>Awaiting Payment</th>
            </thead>
            @foreach($sales as $sale)

                <tr>
                    <td><a href="/manager/sales/{{$sale->id}}"> {{$sale->SaleRef}}</a></td>
                    <td>{{$sale->blank->blank_number}}</td>
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