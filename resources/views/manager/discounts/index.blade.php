@extends('layouts.master')

@section('content')
    <div class="container">
        <h3>Discount Bands</h3>
        @include('layouts.message')

        <a class="btn btn-info" type="button" href="/manager/discounts/create"><i class="fa fa-plus"
                                                                                  aria-hidden="true"></i> Add</a>
        <table class="table">
            <thead>
                <th>Discount Band</th>
                <th>Rate</th>
                <th>Type</th>
            </thead>

            @foreach($discounts as $discount)
                <tr>
                    <td><a href="/manager/discounts/{{$discount->id}}">{{$discount->band}}</a></td>
                    <td>{{$discount->rate}}</td>
                    <td>{{ title_case($discount->type)}}</td>
                </tr>
            @endforeach

        </table>
    </div>
@endsection