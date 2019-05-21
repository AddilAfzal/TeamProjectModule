@extends('layouts.master')

@section('content')
    <div class="container">

        <ol class="breadcrumb">
            <li><a href="/admin">Home</a></li>
            <li><a href="/admin/blanks">Blanks</a></li>
            <li class="active">Search</li>
        </ol>

        <h3>Search Users</h3>
        <h5>{{$message}}</h5>

        @include('layouts.message')

        <table class="table">
            <thead>
            <th>Blank Number</th>
            <th>Assigned To</th>
            <th>Added At</th>
            </thead>

            @foreach($blanks as $blank)
                <tr>
                    <td><a href="/admin/blanks/{{$blank->id}}">{{$blank->blank_number}}</a></td>
                    <td>
                        @if($blank->isAssigned() == true)
                            {{$blank->user['name']}}
                        @else
                            <i>N/A</i>
                        @endif
                    </td>
                    <td>{{$blank->created_at}}</td>
                </tr>
            @endforeach

        </table>
    </div>
@endsection