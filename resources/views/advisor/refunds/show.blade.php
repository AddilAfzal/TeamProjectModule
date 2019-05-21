@extends('layouts.master')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="/advisor">Home</a></li>
            <li class="active">Refunds</li>
        </ol>

        <h3>Refunds</h3>

        @include('layouts.message')


        <table class="table table-bordered">
            <tr>
                <td width="30%">Blank Number</td>
                <td>{{ $refund->blank->blank_number}}</td>
            </tr>
        </table>

        <table class="table table-bordered">
            <tr>
                <td width="30%">Customer</td>
                  <td>  <a href="/advisor/customers/{{$refund->sale->customer->id}}">{{($refund->sale->customer->Firstname . " " . $refund->sale->customer->Surname)}}</a></td>
            </tr>
        </table>

        <table class="table table-bordered">
            <tr>
                <td width="30%">Refund Method</td>
                <td>{{ title_case($refund->method)}}</td>
            </tr>
        </table>

        <table class="table table-bordered">
            <tr>
                <td width="30%">Refund Date & Time</td>
                <td>{{ title_case($refund->created_at)}}</td>
            </tr>
        </table>

        <table class="table table-bordered">
            <tr>
                <td width="30%">Refund Amount</td>
                <td>{{ title_case($refund->amount)}}</td>
            </tr>
        </table>

        <table class="table table-bordered">
            <tr>
                <td width="30%">Reason for Refund</td>
                <td>{{ title_case($refund->reason)}}</td>
            </tr>
        </table>

        <table class="table table-bordered">
            <tr>
                <td width="30%">Sale Reference</td>
                <td>  <a href="/advisor/sales/{{$refund->sale->id}}">{{($refund->sale->SaleRef)}}</a></td>
            </tr>
        </table>


            <p>
                <i>To see the associated sale, click on the sale reference</i>
            </p>
<hr>



    </div>

@endsection