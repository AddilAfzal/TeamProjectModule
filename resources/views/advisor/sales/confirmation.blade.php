@extends('layouts.master')

@section('content')
    <div class="container">
        <h3>Sale Confirmation</h3>
        <form method="post" action="/advisor/sales/">

            <h6>Sale Overview</h6>
            <table class="table">
                {{csrf_field()}}
                <input type="hidden" id="customerId" name="customerId" value="{{old('customerId')}}">

                <tr><td>Blank Number</td><td>{{\App\Blank::find(old('blankId'))->blank_number}}</td></tr>
                <input type="hidden" id="blankNumber" name="blankNumber" value="{{old('blankNumber')}}">

                <tr><td>Sale Amount</td><td>{{old('saleAmount')}}</td></tr>
                <input type="hidden" id="saleAmount"  name="saleAmount" value="{{old('saleAmount')}}">

                {{--  Need to update --}}
                <tr><td>Customer Name</td><td>{{\App\Customer::find(old('customerId'))->Firstname}} {{\App\Customer::find(old('customerId'))->Surname}}</td></tr>
                <input type="hidden" id="searchCustomer" name="searchCustomer" value="{{old('searchCustomer')}}">

                <tr><td>Payment Method</td><td>{{old('paymentMethod')}}</td></tr>
                <input type="hidden" id="paymentMethod"  name="paymentMethod" value="{{old('paymentMethod')}}">


            </table>

            <h6>Passenger</h6>
            <table class="table">
                <tr><td>First Name</td><td>{{old('firstName')}}</td></tr>
                <input type="hidden" id="firstName" name="firstName" value="{{old('firstName')}}">

                <tr><td>Surname</td><td>{{old('surname')}}</td></tr>
                <input type="hidden" id="surname" name="surname" value="{{old('surname')}}">

                <tr><td>Date Of Birth</td><td>{{old('dateOfBirth')}}</td></tr>
                <input type="hidden" id="dateOfBirth" name="dateOfBirth" value="{{old('dateOfBirth')}}">

                <tr><td>Address Line 1</td><td>{{old('addressLine1')}}</td></tr>
                <input type="hidden" id="addressLine1"  name="addressLine1" value="{{old('addressLine1')}}">

                <tr><td>Address Line 2</td><td>{{old('addressLine2')}}</td></tr>
                <input type="hidden" id="addressLine2" name="addressLine2" value="{{old('addressLine2')}}">

                <tr><td>Address Line 3</td><td>{{old('addressLine3')}}</td></tr>
                <input type="hidden" id="addressLine3" name="addressLine3" value="{{old('addressLine3')}}">

                <tr><td>Address Line 4</td><td>{{old('addressLine4')}}</td></tr>
                <input type="hidden" id="addressLine4" name="addressLine4" value="{{old('addressLine4')}}">

                <tr><td>Town</td><td>{{old('town')}}</td></tr>
                <input type="hidden" id="town" name="town" value="{{old('town')}}">

                <tr><td>Postal Area</td><td>{{old('postalArea')}}</td></tr>
                <input type="hidden" id="postalArea" name="postalArea" value="{{old('postalArea')}}">

                <tr><td>Governing District</td><td>{{old('governingDistrict')}}</td></tr>
                <input type="hidden" id="governingDistrict"  name="governingDistrict" value="{{old('governingDistrict')}}">

                <tr><td>Email Address</td><td>{{old('emailAddress')}}</td></tr>
                <input type="hidden" id="emailAddress"  name="emailAddress" value="{{old('emailAddress')}}">

                <tr><td>Primary Phone Number</td><td>{{old('primaryPhoneNumber')}}</td></tr>
                <input type="hidden" id="primaryPhoneNumber" name="primaryPhoneNumber" value="{{old('primaryPhoneNumber')}}">

                <tr><td>Secondary Phone Number</td><td>{{old('secondaryPhoneNumber')}}</td></tr>
                <input type="hidden" id="secondaryPhoneNumber"  name="secondaryPhoneNumber" value="{{old('secondaryPhoneNumber')}}">

            </table>
            <button class="btn btn-primary" type="submit">
                Confirm
            </button>
        </form>
        @include('layouts.errors')
        <hr>
    </div>
@endsection