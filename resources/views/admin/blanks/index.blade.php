@extends('layouts.master')

@section('content')
    <div class="container">

        <ol class="breadcrumb">
            <li><a href="/admin">Home</a></li>
            <li class="active">Blanks</li>
        </ol>

        <h3>Blanks</h3>

        @include('layouts.message')

        <div class="row">
            <div class="col-md-8">
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">All <span class="caret"></span></button>
                    <ul role="menu" class="dropdown-menu">
                        <li><a href="?filter=all" class="active">All</a></li>
                        <li class="divider"></li>
                        <li><a href="?filter=ASSIGNED">Assigned</a></li>
                        <li><a href="?filter=NON-ASSIGNED">Non-Assigned</a></li>
                        <li class="divider"></li>
                        <li><a href="?filter=sold">Sold</a></li>
                    </ul>
                </div>
                <a class="btn btn-info" type="button" href="/admin/blanks/create"><i class="fa fa-plus" aria-hidden="true"></i> Register</a>
            </div>
            <div class="col-md-4">
                <form method="post" action="/admin/blanks/search">
                    <div class="input-group">
                        {{csrf_field()}}
                        <input id="blankNumber" name="blankNumber" type="text" class="form-control" placeholder="Blank Number..." required="">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">Search</button>
                        </span>
                    </div><!-- /input-group -->
                </form>
            </div>
        </div>


        <table class="table">
            <thead><th>Blank Number</th><th>Assigned To</th><th>Registered At</th></thead>

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