@extends('layouts.master')

@section('content')
    <div class="container">
        @include('layouts.message')
        <h3>Welcome back, {{auth()->user()->name}}</h3>

        @if (06 == date('d') && count(\App\Sale::where('AwaitingPayment', '=', true)
                ->where('SaleTime', '>', time() - 2592000)
                ->get()) > 0)
            <<div class="alert alert-warning">
                <h6>Notice</h6>
                <p><a href="/manager/sales/overdue">have overdue payments. Click here to view</a> </p>
            </div>
        @endif

        <h5>Blanks</h5>
        <table class="table table-bordered">
            <tr>
                <td><a href="/manager/blanktypes">View Blank Types</a></td>
            </tr>
            <tr>
                <td><a href="/manager/blanks">View Blanks</a>
                </td>
            </tr>
        </table>


        <h5>Customers</h5>
        <table class="table table-bordered">
            <tr>
                <td>
                    <a href="/manager/customers/create">Create Customer Account</a>
                </td>
            </tr>
            <tr>
                <td>
                    <a href="/manager/customers">View Customer Accounts</a>
                </td>
            </tr>
            <tr>
                <td>
                    <a href="/manager/discounts/">View Discount Bands</a>
                </td>
            </tr>
            </tr>

        </table>

        <h5>Currency</h5>
        <table class="table table-bordered">
            <tr>
            </tr>
            <tr>
                <td><a href="/manager/currencies">View Currencies</a></td>
            </tr>
        </table>

        <h5>Reports</h5>
        <table class="table table-bordered">
            <tr>
                <td>
                    <a href="/manager/reports/individual-sales/create">Individual</a>
                </td>
            </tr>
            <tr>
                <td>
                    <a href="/manager/reports/global-sales/create">Global </a>
                </td>
            </tr>
            <tr>
                <td>
                    <a href="/manager/reports/ticket-stock-turnover/">Ticket Stock Turnover </a>
                </td>
            </tr>

        </table>

        <h5>Sales</h5>
        <table class="table table-bordered">
            <tr>
                <td><a href="/manager/sales/create"> Record Sale</a> </td>
            </tr>
            <tr>
                <td><a href="/manager/sales/">View Sales</a></td>
            </tr>
        </table>

        <h5>Refunds</h5>
        <table class="table table-bordered">
            <tr>
                <td><a href="/manager/refunds/create"> Record Refund</a> </td>
            </tr>
            <tr>
                <td><a href="/manager/refunds/">View Refunds</a></td>
            </tr>
        </table>

    </div>
@endsection