@extends('layouts.master')

@section('content')
    <div class="container">

        <ol class="breadcrumb">
            <li><a href="/manager">Home</a></li>
            <li><a href="/manager/customers">Customers</a></li>
            <li class="active">Search</li>
        </ol>

        <h3>Search Customers</h3>
        <h5>{{$message}}</h5>

        @include('layouts.message')

        <table class="table">
            <thead>
            <th>Customer Name</th>
            <th>Date Of Birth</th>
            <th>Postal Area</th>
            <th>Registration Date</th>
            </thead>

            @foreach($customers as $customer)
                <tr>
                    <td>
                        <a href="/manager/customers/{{$customer->id}}">{{$customer->Firstname}} {{$customer->Surname}}</a>
                    </td>
                    <td>
                        {{$customer->DateOfBirth}}
                    </td>
                    <td>{{$customer->address->PostalArea}}</td>
                    <td>{{$customer->created_at}}</td>
                </tr>
            @endforeach

        </table>
    </div>
@endsection