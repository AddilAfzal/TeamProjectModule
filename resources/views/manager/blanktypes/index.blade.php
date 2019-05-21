@extends('layouts.master')

@section('content')
    <div class="container">

        <ol class="breadcrumb">
            <li><a href="/manager">Home</a></li>
            <li class="active">Blank Types</li>
        </ol>

        <h3>Blank Types</h3>

        @include('layouts.message')
        @include('layouts.errors')

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
                <th>Commission Rate</th>
                <th>Options</th>
            </thead>

            @foreach($types as $type)
                <tr>

                    <td><a href="/manager/blanktypes/{{$type->id}}">{{$type->prefix}}</a></td>
                    <td>{{$type->type}}</td>
                    <td>{{$type->scope}}</td>
                    <td>{{$type->number_of_coupons}}</td>
                    <td>{{count($type->blanks)}}</td>
                    <td>
                        {{$type->commission_rate * 100}}%
                    </td>
                    <td>
                        <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target=".update-com-modal-{{$type->id}}">Update</button>
                    </td>
                </tr>

                <div class="modal fade update-com-modal-{{$type->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action="/manager/blanktypes/update/rate" method="post">

                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="gridSystemModalLabel">Update Commission Rate </h4>
                                </div>

                                <div class="modal-body">
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <input type="hidden" name="blank_type_id" value="{{$type->id}}">
                                        <label for="blank_type_rate">New Commission Rate</label>

                                        <div class="input-group">
                                            <input type="text" class="form-control" name="blank_type_rate" id="blank_type_rate" value="{{$type->commission_rate * 100}}">
                                            <div class="input-group-addon"><i class="fa fa-percent"></i></div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button class="btn btn-primary" type="submit"> Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            @endforeach

        </table>

    </div>
    <hr>

@endsection