@extends('layouts.master')

@section('content')
    <div class="container">

        <ol class="breadcrumb">
            <li><a href="/admin">Home</a></li>
            <li><a href="/admin/currencies">Currencies</a></li>
            <li class="active">Details</li>
        </ol>

        <h3>Currency</h3>
        <h4>{{$currency->CurrencyName}} ({{$currency->CurrencyAbbreviation}})</h4>

        @include('layouts.message')

        <table class="table">
            <tr>
                <td>
                    Name
                </td>
                <td>
                    {{$currency->CurrencyName}}
                </td>
            </tr>
            <tr>
                <td>
                    Abbreviation
                </td>
                <td>
                    {{$currency->CurrencyAbbreviation}}
                </td>
            </tr>
            <tr>
                <td>
                    USD to {{$currency->CurrencyAbbreviation}}
                </td>
                <td>
                    {{$currency->Rate}}
                </td>
            </tr>
            <tr>
                <td>
                    {{$currency->CurrencyAbbreviation}} to USD
                </td>
                <td>
                    {{round(1/$currency->Rate,5)}}
                </td>
            </tr>
            <tr>
                <td>
                     Created At
                </td>
                <td>
                    {{$currency->created_at}}
                </td>
            </tr>
            <tr>
                <td>
                    Updated At
                </td>
                <td>
                    {{$currency->updated_at}}
                </td>
            </tr>
        </table>

    </div>
    <hr>

@endsection