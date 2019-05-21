@extends('layouts.master')

@section('content')
    <div class="container">

        <ol class="breadcrumb">
            <li><a href="/admin">Home</a></li>
            <li class="active">Currencies</li>
        </ol>

        <h3>Currencies</h3>

        @include('layouts.message')

        <a class="btn btn-info" type="button" href="/admin/currencies/create"><i class="fa fa-plus" aria-hidden="true"></i> Create</a>

        <table class="table">
            <thead>
            <th>Name</th>
            <th>Abbreviation</th>
            <th>1 USD to Currency</th>
            </thead>

            @foreach($currencies as $currency)
                <tr>
                    <td><a href="/admin/currencies/{{$currency->id}}">{{$currency->CurrencyName}}</a></td>
                    <td>{{$currency->CurrencyAbbreviation}}</td>
                    <td>{{$currency->Rate}}</td>
                </tr>
            @endforeach

        </table>
    </div>
@endsection