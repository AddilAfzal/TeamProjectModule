@extends('layouts.master')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="/advisor">Home</a></li>
            <li class="active">Customers</li>
        </ol>

        <h3>Customer Details</h3>

        @include('layouts.message')

        <div class="row">
            <div class="col-md-8">
                <a href="/manager/customers/create" class="btn btn-primary"><i class="fa fa-plus"></i> Create Account</a>
            </div>
            <div class="col-md-4">
                <form method="post" action="/manager/customers/search">
                    <div class="input-group">
                        {{csrf_field()}}
                        <input id="customerName" name="customerName" type="text" class="form-control" placeholder="Last Name" required="">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">Search</button>
                        </span>
                    </div><!-- /input-group -->
                </form>
            </div>
        </div>

        <table class="table">

            <thead>
            <th>Title</th>
            <th>First Name</th>
            <th>Surname</th>
            <th>DOB</th>
            </thead>
            @foreach($customers as $customer)

                <tr>
                    <td>{{$customer->Title}}</td>
                    <td><a href="/manager/customers/{{$customer->id}}">{{$customer->Firstname}}</a></td>
                    <td>{{$customer->Surname}}</td>
                    <td>{{$customer->DateOfBirth}}</td>
                </tr>
            @endforeach


        </table>
    </div>

@endsection