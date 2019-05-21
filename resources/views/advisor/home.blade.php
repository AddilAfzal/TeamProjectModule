@extends('layouts.master')

@section('content')
    <div class="container">
        <h3>Welcome back, {{auth()->user()->name}}</h3>

        <br>

        <h5>Sales</h5>
        <table class="table table-bordered">
            <tr>
                <td><a href="/advisor/sales/create"> Record Sale</a> </td>
            </tr>
            <tr>
                <td><a href="/advisor/sales/">View Sales</a></td>
            </tr>
        </table>

        <h5>Refunds</h5>
        <table class="table table-bordered">
            <tr>
                <td><a href="/advisor/refunds/create"> Record Refund</a> </td>
            </tr>
            <tr>
                <td><a href="/advisor/refunds/">View Refunds</a></td>
            </tr>
        </table>

        <h5>Customer</h5>
        <table class="table table-bordered">
            <tr>
                <td> <a href="/advisor/customers/create"> Create Customer Account </a></td>
            </tr>
            <tr>
                <td><a href="/advisor/customers">View Customer Account</a></td>
            </tr>

        </table>

        <h5>Reports</h5>
        <table class="table table-bordered">
            <tr>
                <td><a href="/advisor/reports/individual-sales/create">Generate Personal Sales Reports</a></td>

            </tr>
        </table>
    </div>
@endsection