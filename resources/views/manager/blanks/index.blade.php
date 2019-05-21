@extends('layouts.master')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="/manager">Home</a></li>
            <li class="active">Blanks</li>
        </ol>

        <h3>Blanks</h3>
        @if($blanks->currentPage() != 1)
            <h5>Page {{$blanks->currentPage()}}</h5>
        @endif

        @include('layouts.message')

        <div class="row">
            <div class="col-md-4">
                <form method="post" action="/manager/blanks/search">
                    <div class="input-group">
                        {{csrf_field()}}
                        <input id="blankNumber" name="blankNumber" type="text" class="form-control"
                               placeholder="Blank Number..." required="">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">Search</button>
                        </span>
                    </div><!-- /input-group -->
                </form>
            </div>
        </div>
        <hr>


        <table class="table">
            <thead>
            <th>Blank Number</th>
            <th>Assigned To</th>
            <th>Registered At</th>
            </thead>

            @foreach($blanks as $blank)
                <tr>
                    <td><a href="/manager/blanks/{{$blank->id}}">{{$blank->blank_number}}</a></td>
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

    </div>
@endsection