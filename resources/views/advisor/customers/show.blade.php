@extends('layouts.master')

@section('content')
    <div class="container">

        <ol class="breadcrumb">
            <li><a href="/manager/">Home</a></li>
            <li><a href="/manager/customers">Customers</a></li>
            <li class="active">Customer Details : {{$customer->Firstname}} {{$customer->Surname}}</li>
        </ol>

        @include('layouts.message')
        @include('layouts.errors')

        @if($customer->discount->type == 'NONE' AND $customer->Type == 'VALUED')
            <div class="alert alert-dismissable alert-warning">
                <b>Notice</b>
                <p>This customer account is marked as valued but does not seem to have a discount plan assigned.</p>
            </div>
        @endif

        <h3>Customer Details</h3>
        <table class="table table-bordered">
            <tr>
                <td width="30%">Title</td>
                <td>{{$customer->Title}}</td>
            </tr>
            <tr>
                <td>First Name</td>
                <td>{{$customer->Firstname}}</td>
            </tr>
            <tr>
                <td>Surname</td>
                <td>{{$customer->Surname}}</td>
            </tr>
            <tr>
                <td>DOB</td>
                <td>{{$customer->DateOfBirth}}</td>
            </tr>
            <tr>
                <td>Type</td>
                <td>{{ title_case($customer->Type)}}</td>
            </tr>
            <tr>
                <td>Registration Date</td>
                <td>{{$customer->created_at}}</td>
            </tr>
            <tr>
                <td>Last Updated</td>
                <td>{{ ($customer->updated_at == null) ? "Never" : $customer->updated_at }}</td>
            </tr>

        </table>

        <br>

        <h5>Address</h5>
        <table class="table table-bordered">
            <tr>
                <td width="30%">Address Line 1</td>
                <td>{{$customer->address->AddressLine1}}</td>
            </tr>
            <tr>
                <td>Address Line 2</td>
                <td>
                    @if($customer->address->AddressLine2 == "")
                        -
                    @else
                        {{$customer->address->AddressLine2}}
                    @endif
                </td>
            </tr>
            <tr>
                <td>Address Line 3</td>
                <td>
                    @if($customer->address->AddressLine3 == "")
                        -
                    @else
                        {{$customer->address->AddressLine3}}
                    @endif
                </td>
            </tr>
            <tr>
                <td>Address Line 4</td>
                <td>
                    @if($customer->address->AddressLine4 == "")
                        -
                    @else
                        {{$customer->address->AddressLine4}}
                    @endif
                </td>
            </tr>
            <tr>
                <td>Town/City</td>
                <td>{{$customer->address->CityTown}}</td>
            </tr>
            <tr>
                <td>Postal Area</td>
                <td>{{$customer->address->PostalArea}}</td>
            </tr>
            <tr>
                <td>Governing District</td>
                <td>{{$customer->address->GoverningDistrict}}</td>
            </tr>

        </table>

        <br>

        <h5>Contact Details</h5>
        <table class="table table-bordered">
            <tr>
                <td width="30%">Email Address</td>
                <td>{{$customer->EmailAddress}}</td>
            </tr>
            <tr>
                <td>Phone No.(Primary)</td>
                <td>{{$customer->PrimaryPhoneNumber}}</td>
            </tr>
            <tr>
                <td>Phone No.(Secondary)</td>
                <td>
                    @if($customer->address->SecondaryPhoneNumber == "")
                        -
                    @else
                        {{$customer->address->SecondaryPhoneNumber}}
                    @endif
                </td>
            </tr>
        </table>

        <br>

        @if($customer->discount->type != 'NONE')
            <h5>Discount</h5>
            <table class="table table-bordered">
                <tr>
                    <td width="30%">Type</td>
                    <td>{{ title_case($customer->discount->type)}}</td>
                </tr>

                @if($customer->discount->type == 'FIXED')
                    <tr>
                        <td>Rate</td>
                        <td>{{ $customer->discount->rate * 100}}%</td>
                    </tr>
                @else
                    <tr>
                        <td>Rate</td>
                        <td>
                            <ul class="list-group">
                                @foreach($discountRanges as $max => $rate)
                                    @if($max == 0)
                                        <li class="list-group-item">Otherwise {{$rate * 100}}%</li>
                                    @else
                                        <li class="list-group-item">Sales up
                                            to {{$max}} {{\App\Currency::find(\App\TravelAgent::getLocalCurrency())->CurrencyAbbreviation }}
                                            = {{$rate * 100}}%
                                        </li>

                                    @endif
                                @endforeach
                            </ul>

                        </td>
                    </tr>
                @endif


            </table>
        @endif

        <br>



        <!-- Change Contact Details Action -->
        <button type="button" class="btn btn-info" data-toggle="modal" data-target=".update-contact-modal"><i
                    class="fa fa-address-book" aria-hidden="true"></i> Update Contact Details
        </button>

        <div class="modal fade update-contact-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="/advisor/customers/update/contact" method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="gridSystemModalLabel">
                                Update Contact Details</h4>
                        </div>
                        <div class="modal-body">
                            {{csrf_field()}}
                            <input type="hidden" name="customerId" value="{{$customer->id}}">
                            <!-- Address Line 1-->
                            <div class="form-group {{ $errors->has('addressLine1') ? ' has-error' : '' }}">
                                <label class="control-label" for="addressLine1">Address Line 1</label>
                                <input id="addressLine1" name="addressLine1" required type="text"
                                       placeholder="Address Line 1"
                                       class="form-control input-md" value="{{$customer->address->AddressLine1}}">
                            </div>

                            <!-- Address Line 2-->
                            <div class="form-group {{ $errors->has('addressLine2') ? ' has-error' : '' }}">
                                <label class="control-label" for="addressLine2">Address Line 2</label>
                                <input id="addressLine2" name="addressLine2" type="text" placeholder="Address Line 2"
                                       class="form-control input-md" value="{{$customer->address->AddressLine2}}">
                            </div>

                            <!-- Address Line 3-->
                            <div class="form-group {{ $errors->has('addressLine3') ? ' has-error' : '' }}">
                                <label class="control-label" for="addressLine3">Address Line 3</label>
                                <input id="addressLine3" name="addressLine3" type="text" placeholder="Address Line 3"
                                       class="form-control input-md" value="{{$customer->address->AddressLine3}}">
                            </div>

                            <!-- Address Line 4-->
                            <div class="form-group {{ $errors->has('addressLine4') ? ' has-error' : '' }}">
                                <label class="control-label" for="addressLine4">Address Line 4</label>
                                <input id="addressLine4" name="addressLine4" type="text" placeholder="Address Line 4"
                                       class="form-control input-md" value="{{$customer->address->AddressLine4}}">
                            </div>

                            <!-- Town/City-->
                            <div class="form-group {{ $errors->has('town') ? ' has-error' : '' }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="control-label" for="town">Town/City</label>
                                        <input id="town" name="town" required type="text" placeholder="Town/City"
                                               class="form-control input-md" value="{{$customer->address->CityTown}}">
                                    </div>
                                </div>
                            </div>

                            <!-- PostalArea-->
                            <div class="form-group {{ $errors->has('postalArea') ? ' has-error' : '' }}">
                                <div class="row">
                                    <div class="col-md-5">
                                        <label class="control-label" for="postalArea">Postal Area</label>
                                        <input id="postalArea" name="postalArea" required type="text"
                                               placeholder="Postal Area"
                                               class="form-control input-md" value="{{$customer->address->PostalArea}}">
                                    </div>
                                </div>
                            </div>

                            <!-- Governing District-->
                            <div class="form-group {{ $errors->has('governingDistrict') ? ' has-error' : '' }}">
                                <div class="row">
                                    <div class="col-md-5">
                                        <label class="control-label" for="governingDistrict">Country</label>
                                        <input id="governingDistrict" name="governingDistrict" required type="text"
                                               placeholder="Governing District"
                                               class="form-control input-md"
                                               value="{{$customer->address->GoverningDistrict}}">
                                    </div>
                                </div>
                            </div>

                            <!-- Email Address-->
                            <div class="form-group {{ $errors->has('emailAddress') ? ' has-error' : '' }}">
                                <label class="control-label" for="emailAddress">Email Address</label>
                                <input id="emailAddress" name="emailAddress" type="email" placeholder="Email address"
                                       class="form-control input-md" value="{{$customer->EmailAddress}}">
                            </div>

                            <!-- Phone Number (Primary)-->
                            <div class="form-group {{ $errors->has('primaryPhoneNumber') ? ' has-error' : '' }}">
                                <label class="control-label" for="primaryPhoneNumber">Phone No.(Primary)</label>
                                <input id="primaryPhoneNumber" pattern='[\+]\d{2}\d{2}\d{4}\d{4}'
                                       name="primaryPhoneNumber" required
                                       type="tel" placeholder="Phone Number"
                                       class="form-control input-md" value="{{$customer->PrimaryPhoneNumber}}">
                                <p class="help-block">Format: <i>+999999999999</i></p>

                            </div>

                            <!-- Phone Number (Secondary)-->
                            <div class="form-group {{ $errors->has('secondaryPhoneNumber') ? ' has-error' : '' }}">
                                <label class="control-label" for="secondaryPhoneNumber">Phone No.(Secondary)</label>
                                <input id="secondaryPhoneNumber" pattern='[\+]\d{2}\d{2}\d{4}\d{4}'
                                       name="secondaryPhoneNumber"
                                       type="tel" placeholder="Optional Phone Number"
                                       class="form-control input-md" value="{{$customer->SecondaryPhoneNumber}}">
                                <p class="help-block">Format: <i>+999999999999</i></p>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary" type="submit"><i
                                        class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>
                                Update Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        {{--<!-- Print Payment Reminder Letter Action -->--}}
        {{--<button type="button" class="btn btn-danger" data-toggle="modal" data-target=".delete-modal"><i--}}
        {{--class="fa fa-trash-o" aria-hidden="true"></i> Delete--}}
        {{--</button>--}}

        {{--<div class="modal fade delete-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">--}}
        {{--<div class="modal-dialog" role="document">--}}
        {{--<div class="modal-content">--}}
        {{--<form action="/admin/users/delete/" method="post">--}}

        {{--<div class="modal-header">--}}
        {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span--}}
        {{--aria-hidden="true">&times;</span></button>--}}
        {{--<h4 class="modal-title" id="gridSystemModalLabel">Delete Confirmation</h4>--}}
        {{--</div>--}}

        {{--<div class="modal-body">--}}
        {{--{{csrf_field()}}--}}
        {{--<div class="form-group">--}}
        {{--<input type="hidden" name="user_id" value="{{$user->id}}">--}}
        {{--<p>Are you sure that you would like to delete this user account?</p>--}}
        {{--</div>--}}

        {{--</div>--}}
        {{--<div class="modal-footer">--}}
        {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
        {{--<button class="btn btn-danger" type="submit"><i class="fa fa-trash-o"--}}
        {{--aria-hidden="true"></i> Delete--}}
        {{--</button>--}}

        {{--</div>--}}
        {{--</form>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}

    </div>
    <hr>

@endsection