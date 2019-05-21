@extends('layouts.master')

@section('content')
    <div class="container">

        <ol class="breadcrumb">
            <li><a href="/advisor">Home</a></li>
            <li><a href="/advisor/customers">Customers</a></li>
            <li class="active">Create Account</li>
        </ol>

        <h3>New Customer Account</h3>
        <form method="post" action="/advisor/customers">

            {{csrf_field()}}

            <fieldset>
                <!-- Title -->
                <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
                    <label class="control-label" for="title">Title
                    </label>
                    <select id="title" name="title" class="form-control" required>
                        <option value="" disabled selected>Select Title</option>
                        @foreach(\App\Customer::$valid_titles as $title1)
                            <option value="{{$title1}}">{{$title1}}</option>
                        @endforeach
                    </select>

                </div>


                <!-- First name and Surname-->
                <div class="form-group {{ $errors->has('firstName') ? ' has-error' : '' }}">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label" for="firstName">First Name</label>
                            <input id="firstName" name="firstName" required type="text" placeholder="Firstname"
                                   class="form-control input-md" value="{{old('firstName')}}">
                        </div>
                        <div class="col-md-6">
                            <label class="control-label" for="surname">Surname</label>
                            <input id="surname" name="surname" required  type="text" placeholder="Surname"
                                   class="form-control input-md" value="{{old('surname')}}">
                        </div>
                    </div>
                </div>

                <!-- DOB-->
                <div class="form-group {{ $errors->has('dateOfBirth') ? ' has-error' : '' }}">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="control-label" for="dateOfBirth">DOB</label>
                            <input id="dateOfBirth" name="dateOfBirth" required type="date"
                                   max="<?php echo date("Y-m-d")?>"
                                   pattern="\d{1,2}/\d{1,2}/\d{4}" placeholder="Date Of Birth"
                                   class="form-control input-md" value="{{old('dateOfBirth')}}">
                            <p class="help-block">Format: <i>dd/mm/yyyy</i></p>

                        </div>
                    </div>
                </div>

                <!-- Address Line 1-->
                <div class="form-group {{ $errors->has('addressLine1') ? ' has-error' : '' }}">
                    <label class="control-label" for="addressLine1">Address Line 1</label>
                    <input id="addressLine1" name="addressLine1" required type="text" placeholder="Address Line 1"
                           class="form-control input-md" value="{{old('addressLine1')}}">
                </div>

                <!-- Address Line 2-->
                <div class="form-group {{ $errors->has('addressLine2') ? ' has-error' : '' }}">
                    <label class="control-label" for="addressLine2">Address Line 2</label>
                    <input id="addressLine2" name="addressLine2" type="text" placeholder="Address Line 2"
                           class="form-control input-md" value="{{old('addressLine2')}}">
                </div>

                <!-- Address Line 3-->
                <div class="form-group {{ $errors->has('addressLine3') ? ' has-error' : '' }}">
                    <label class="control-label" for="addressLine3">Address Line 3</label>
                    <input id="addressLine3" name="addressLine3" type="text" placeholder="Address Line 3"
                           class="form-control input-md" value="{{old('addressLine3')}}">
                </div>

                <!-- Address Line 4-->
                <div class="form-group {{ $errors->has('addressLine4') ? ' has-error' : '' }}">
                    <label class="control-label" for="addressLine4">Address Line 4</label>
                    <input id="addressLine4" name="addressLine4" type="text" placeholder="Address Line 4"
                           class="form-control input-md" value="{{old('addressLine4')}}">
                </div>

                <!-- Town/City-->
                <div class="form-group {{ $errors->has('town') ? ' has-error' : '' }}">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="control-label" for="town">Town/City</label>
                            <input id="town" name="town" required type="text" placeholder="Town/City"
                                   class="form-control input-md" value="{{old('town')}}">
                        </div>
                    </div>
                </div>

                <!-- PostalArea-->
                <div class="form-group {{ $errors->has('postalArea') ? ' has-error' : '' }}">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="control-label" for="postalArea">Postal Area</label>
                            <input id="postalArea" name="postalArea" required type="text" placeholder="Postal Area"
                                   class="form-control input-md" value="{{old('postalArea')}}">
                        </div>
                    </div>
                </div>

                <!-- Governing District-->
                <div class="form-group {{ $errors->has('governingDistrict') ? ' has-error' : '' }}">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="control-label" for="governingDistrict">Country</label>
                            <input id="governingDistrict" name="governingDistrict" required type="text"
                                   placeholder="Governing District"
                                   class="form-control input-md" value="{{old('governingDistrict')}}">
                        </div>
                    </div>
                </div>

                <!-- Email Address-->
                <div class="form-group {{ $errors->has('emailAddress') ? ' has-error' : '' }}">
                    <label class="control-label" for="emailAddress">Email Address</label>
                    <input id="emailAddress" name="emailAddress" type="email" placeholder="Email address"
                           class="form-control input-md" value="{{old('emailAddress')}}">
                </div>

                <!-- Phone Number (Primary)-->
                <div class="form-group {{ $errors->has('primaryPhoneNumber') ? ' has-error' : '' }}">
                    <label class="control-label" for="primaryPhoneNumber">Phone No.(Primary)</label>
                    <input id="primaryPhoneNumber" pattern='[\+]\d{2}\d{2}\d{4}\d{4}' name="primaryPhoneNumber" required
                           type="tel" placeholder="Phone Number"
                           class="form-control input-md" value="{{old('primaryPhoneNumber')}}">
                    <p class="help-block">Format: <i>+999999999999</i></p>

                </div>

                <!-- Phone Number (Secondary)-->
                <div class="form-group {{ $errors->has('secondaryPhoneNumber') ? ' has-error' : '' }}">
                    <label class="control-label" for="secondaryPhoneNumber">Phone No.(Secondary)</label>
                    <input id="secondaryPhoneNumber" pattern='[\+]\d{2}\d{2}\d{4}\d{4}' name="secondaryPhoneNumber"
                           type="tel" placeholder="Optional Phone Number"
                           class="form-control input-md" value="{{old('secondaryPhoneNumber')}}">
                    <p class="help-block">Format: <i>+999999999999</i></p>

                </div>

                <!-- Preferred Payment Method -->
                <div class="form-group {{ $errors->has('paymentMethod') ? ' has-error' : '' }}">
                    <label class="control-label" for="paymentMethod">Preferred Payment Method</label>
                    <div class="radio">
                        <label for="paymentMethod-0">
                            <input type="radio" name="paymentMethod" id="paymentMethod-0" value="CARD"
                                   checked="checked">
                            Credit/Debit Card
                        </label>
                    </div>
                    <div class="radio">
                        <label for="paymentMethod-1">
                            <input type="radio" name="paymentMethod" id="paymentMethod-1" value="CASH">
                            Cash
                        </label>
                    </div>
                </div>

            </fieldset>

            <!-- Submit and reset buttons -->
            <div class="form-group {{ $errors->has('submit') ? ' has-error' : '' }}">
                <div class="row">
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">Add Customer</button>
                    </div>
                    <div class="col-md-2">
                        <button type="reset" value="reset" class="btn btn-default">Reset</button>
                    </div>
                </div>
            </div>
        </form>
        @include('layouts.errors')
    </div>
    <hr>
@endsection