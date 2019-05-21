@extends('layouts.master')

@section('content')
    <div class="container">
        @include('layouts.message')
        <h3>Welcome back, {{auth()->user()->name}}</h3>

        <h5>Blanks</h5>
        <table class="table table-bordered">
            <tr>
                <td><a href="/admin/blanks/create">Register Blank</a></td>
            </tr>
            <tr>
                <td><a href="/admin/blanks">View Blanks</td>
            </tr>
            <tr>
                <td><a href="/admin/blanktypes/create">Add Blank Type</a></td>
            </tr>
            <tr>
                <td><a href="/admin/blanktypes">View Blank Types</a></td>
            </tr>
        </table>

        <h5>Users</h5>
        <table class="table table-bordered">
            <tr>
                <td><a href="/admin/users/create">Register User</a></td>
            </tr>
            <tr>
                <td><a href="/admin/users">View Users</a></td>
            </tr>
        </table>



        <h5>Travel Agent</h5>
        <table class="table table-bordered">
            <tr>
                <td><a href="/admin/travelagent/edit">Change Business Details</a></td>
            </tr>
            <tr>
                <td><a href="/admin/travelagent/">View Business Details</a></td>
            </tr>
        </table>

        <h5>Backup</h5>
        <table class="table table-bordered">
            <tr>
                <td><a href="/admin/backups">View Backups</a></td>
            </tr>
        </table>

        <h5>Currency</h5>
        <table class="table table-bordered">
            <tr>
                <td><a href="/admin/currencies/create">Add Currency</a></td>
            </tr>
            <tr>
                <td><a href="/admin/currencies">View Currencies</a></td>
            </tr>
        </table>

        <h5>Report</h5>
        <table class="table table-bordered">
            <tr>
                <td><a href="/admin/reports/ticket-stock-turnover/">Ticket Stock Turnover Report</a></td>
            </tr>
        </table>

    </div>
@endsection