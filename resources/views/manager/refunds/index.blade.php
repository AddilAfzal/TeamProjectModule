@extends('layouts.master')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="/manager">Home</a></li>
            <li class="active">Refunds</li>
        </ol>
        <h3>Refunds</h3>

        @include('layouts.message')

        <table class="table">

            <thead>
                <th>Blank Number</th>
                <th>Customer</th>
                <th>Refund Method</th>
                <th>Refund Date & Time</th>
            </thead>

            @foreach($refunds as $refund)

                <tr>
                    <td><a href="/manager/refunds/{{$refund->id}}">{{$refund->blank->blank_number}}</a></td>
                    <td>{{  title_case($refund->sale->customer->Firstname . " " . $refund->sale->customer->Surname)}}</td>
                    <td>{{  title_case($refund->method) }}</td>
                    <td>{{  title_case($refund->created_at) }}</td>
                </tr>

            @endforeach

        </table>

        <!-- Issue Refund buttons -->
        <div class="form-group {{ $errors->has('submit') ? ' has-error' : '' }}">
            <div class="row">
                <div class="col-md-2">
                    <a href="/manager/refunds/create" type="submit" class="btn btn-primary">Record Refund</a>
                </div>
            </div>
        </div>
    </div>

@endsection