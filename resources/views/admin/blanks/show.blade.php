@extends('layouts.master')

@section('content')
    <div class="container">

        <ol class="breadcrumb">
            <li><a href="/admin">Home</a></li>
            <li><a href="/admin/blanks">Blanks</a></li>
            <li class="active">Blank Details </li>
        </ol>

        <h3>Blank Details</h3>
        <h4>{{$blank->blank_number}}</h4>

        @include('layouts.message')

        <table class="table">
            <tr>
                <td>
                    <b>Blank Type:</b> {{$blank->blank_type->prefix}}
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Assigned User:</b>
                    @if($blank->user != null)
                    {{$blank->user->name}}
                    @else
                        <i>N/A</i>
                    @endif
                </td>
                <td>

                </td>
            </tr>
            <tr>
                <td>
                    <b>Sold:</b> @if($blank->is_sold == 0)
                        No
                    @elseif($blank->is_sold == 1)
                        Yes
                    @endif

                </td>
                <td>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Created At:</b> {{$blank->created_at}}
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <td>
                    <b>Updated At:</b> {{$blank->updated_at}}
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <td>

                </td>
                <td>
                </td>
            </tr>
        </table>

        <h5>Coupons</h5>
        <table class="table">
            <thead>
            <th>Flight No:</th>
            <th>Departure from:</th>
            <th>Departure time:</th>
            <th>Arrival to:</th>
            <th>Arrival time:</th>
            </thead>
            @foreach($blank->coupons as $coupon)
                <tr>
                    <td>{{$coupon->flight_number}}</td>
                    <td>{{$coupon->departure_from}}</td>
                    <td>{{$coupon->departure_time}}</td>
                    <td>{{$coupon->arrival_to}}</td>
                    <td>{{$coupon->arrival_time}}</td>
                </tr>
            @endforeach
        </table>

        <h5>Options</h5>

        <!-- Assign Action -->
        @if($blank->user_id == 0)
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".assign-modal"><i
                        class="fa fa-arrow-circle-o-right" aria-hidden="true"></i> Assign
            </button>
        @elseif($blank->user_id > 0)
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".assign-modal"><i
                        class="fa fa-arrow-circle-o-right" aria-hidden="true"></i> Reassign
            </button>
        @endif

        <div class="modal fade assign-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="/admin/blanks/assign/" method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="gridSystemModalLabel">
                                @if($blank->user_id == 0)
                                    Assign
                                @elseif($blank->user_id > 0)
                                    Reassign
                                @endif
                                Blank</h4>
                        </div>
                        <div class="modal-body">
                            {{csrf_field()}}
                            <div class="form-group">
                                <input type="hidden" name="blankId" value="{{$blank->id}}">
                                <label for="travelAdvisor">Travel Advisor</label>
                                <select class="form-control" id="travelAdvisor" name="travelAdvisor" required>
                                    <option value="" disabled="" selected="">Select your option</option>
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            @if($blank->user_id == 0)
                                <button class="btn btn-primary" type="submit"><i
                                            class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>
                                    Assign</button>
                            @elseif($blank->user_id > 0)
                                <button class="btn btn-primary" type="submit"><i
                                            class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>
                                    Reassign
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Action -->
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target=".delete-modal"><i
                    class="fa fa-trash-o" aria-hidden="true"></i> Delete
        </button>

        <div class="modal fade delete-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="/admin/blanks/delete/" method="post">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="gridSystemModalLabel">Delete Confirmation</h4>
                        </div>

                        <div class="modal-body">
                            {{csrf_field()}}
                            <div class="form-group">
                                <input type="hidden" name="blankId" value="{{$blank->id}}">
                                <p>Are you sure that you would like to delete this blank with
                                    number {{$blank->blank_number}}?</p>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button class="btn btn-danger" type="submit"><i class="fa fa-trash-o"
                                                                            aria-hidden="true"></i> Delete
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <hr>

@endsection