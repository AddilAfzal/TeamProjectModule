@extends('layouts.master')

@section('content')
    <div class="container">

        <ol class="breadcrumb">
            <li><a href="/admin">Home</a></li>
            <li class="active">Blank Types</li>
        </ol>

        <h3>Blank Types</h3>

        @include('layouts.message')

        <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">Filter <span
                        class="caret"></span></button>
            <ul role="menu" class="dropdown-menu">
                <li><a href="/{{auth()->user()->role}}/blanktypes" class="active">All</a></li>
                <li class="divider"></li>
                <li><a href="/{{auth()->user()->role}}/blanktypes?filter=INTERLINE">Interline</a></li>
                <li><a href="/{{auth()->user()->role}}/blanktypes?filter=DOMESTIC">Domestic</a></li>
            </ul>
        </div>
        <a class="btn btn-info" type="button" href="/{{auth()->user()->role}}/blanktypes/create"><i class="fa fa-plus"
                                                                                                    aria-hidden="true"></i>
            Add</a>

        <table class="table table-hover">

            <thead>
                <th>Prefix</th>
                <th>Type</th>
                <th>Scope</th>
                <th>Number of Coupons</th>
                <th>Blanks</th>
            </thead>

            @foreach($types as $type)
                <tr>

                    <td><a href="/admin/blanktypes/{{$type->id}}">{{$type->prefix}}</a></td>
                    <td>{{$type->type}}</td>
                    <td>{{$type->scope}}</td>
                    <td>{{$type->number_of_coupons}}</td>
                    <td>{{count($type->blanks)}}</td>
                    <td>{{$type->created_at}}</td>
                </tr>
            @endforeach

        </table>

    </div>
    <hr>

@endsection