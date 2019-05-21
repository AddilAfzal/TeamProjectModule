@extends('layouts.master')

@section('content')
    <div class="container">

        <ol class="breadcrumb">
            <li><a href="/manager">Home</a></li>
            <li><a href="/manager/blanktypes">Blank Types</a></li>
            <li class="active">Details</li>
        </ol>

        <h3>Blank Type Details</h3>
        @include('layouts.message')


        <h5>Blanks of Type {{$blank_type->prefix}}</h5>
        @if(count($blank_type->blanks) > 0)
            <table class="table table-hover">
                <thead>
                <th>Blank Number</th>
                <th>Assigned To</th>
                <th>Registered At</th>
                <th>Assigned At</th>
                </thead>
                @foreach($blanks as $blank)
                    <tr>
                        <td><a href="/manager/blanks/{{$blank->id}}">{{$blank->blank_number}}</a></td>
                        <td>
                            @if($blank->isAssigned() == true)
                                {{$blank->user->name}}
                            @else
                                <i>N/A</i>
                            @endif
                        </td>
                        <td>{{$blank->created_at}}</td>
                        <td>{{ ($blank->assigned_at) ? $blank->assigned_at : "-"}}</td>
                    </tr>
                @endforeach
            </table>

            @if(!($blanks->hasMorePages() == 0 && $blanks->currentPage() == 1))
                <nav aria-label="...">
                    <ul class="pager">
                        <li class="@if($blanks->currentPage() == 1) disabled @endif"><a
                                    href="{{$blanks->previousPageUrl()}}">Previous</a></li>
                        <li class="@if($blanks->hasMorePages() == 0) disabled @endif"><a
                                    href="{{$blanks->nextPageUrl()}}">Next</a></li>
                    </ul>
                </nav>
            @endif
        @else
            <div class="alert alert-warning"><b>Information</b> There aren't any blanks of type {{$blank_type->prefix}}
            </div>
        @endif

    </div>
    <hr>

@endsection