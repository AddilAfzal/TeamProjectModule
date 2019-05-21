@extends('layouts.master')

@section('content')
    <div class="container">
        <h3>Blank</h3>
        <h4>{{$blank->blank_number}}</h4>

        @include('layouts.message')

        <table class="table">
            <tr>
                <td>
                    Blank ID: {{$blank->blank_type->prefix}}
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <td>
                    Assigned User:
                    @if($blank->user_id != 0)
                        {{$blank->user->name}}
                    @else
                        -
                    @endif

                </td>
                <td>

                </td>
            </tr>
            <tr>
                <td>
                    Sold: @if($blank->is_sold == 0)
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
                    Created At: {{$blank->created_at}}
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <td>
                    Updated At: {{$blank->updated_at}}
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
                    <form action="/manager/blanks/assign/" method="post">
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
                                    Assign
                                </button>
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
        <hr>
    </div>
@endsection