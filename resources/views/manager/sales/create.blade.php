@extends('layouts.master')

@section('content')
    <div class="container">

        <ol class="breadcrumb">
            <li><a href="/manager">Home</a></li>
            <li><a href="/manager/sales">Sales</a></li>
            <li class="active">Record Sale</li>
        </ol>

        <h3>New Sale</h3>
        <form method="post" action="/manager/sales/">

            {{csrf_field()}}
            <fieldset>

                <div class="form-group {{ $errors->has('blankId') ? ' has-error' : '' }}">
                    <label class="control-label" for="blankId">Blank
                        Number</label> {{--select blank no from blanks table, where blanks have been solved  --}}
                    <select id="blankId" name="blankId" class="form-control" required>
                        @if(!(null !== old('blankId')))
                            <option value="" disabled selected>Select Blank Number</option>
                        @endif

                        @foreach($blanks as $blank)
                            @if($blank->blank_number == old('blankId'))
                                <option value="{{$blank->id}}" selected>{{$blank->blank_number}}</option>
                            @else
                                <option value="{{$blank->id}}">{{$blank->blank_number}}</option>
                            @endif

                        @endforeach
                    </select>
                </div>

                <!-- Fare -->
                <div class="form-group {{ $errors->has('fare') ? ' has-error' : '' }}">
                    <label class="control-label" for="fare">Fare</label>
                    <input id="fare" name="fare" type="text" placeholder="Fare"
                           pattern="/^\d+(\.|\,)?\d{2}$/"
                           class="form-control input-md" value="{{old('fare')}}" required>
                </div>

                <!-- Tax -->
                <div class="form-group {{ ($errors->has('taxLocal') || $errors->has('taxOther')) ? ' has-error' : '' }}">
                    <label class="control-label" for="taxLocal">Tax</label>
                    <input id="taxLocal" name="taxLocal" type="text" placeholder="Local"
                           pattern="^\d+\(\.|\,)\d{2}$"
                           class="form-control input-md" value="{{old('taxLocal')}}" required>
                    <label class="control-label" for="taxOther"></label>
                    <input id="taxOther" name="taxOther" type="text" placeholder="Other"
                           pattern="/^\d+(\.|\,)?\d{2}$/"
                           class="form-control input-md" value="{{old('taxOther')}}" required>
                </div>

                <!-- Search Customer-->
                <div class="form-group {{ $errors->has('searchCustomer') ? ' has-error' : '' }}">
                    <label class="control-label" for="searchCustomer">Search Customer</label>
                    <div class="row">
                        <div class="col-md-6">
                            <input id="searchCustomer" name="searchCustomer" type="text" placeholder="First Name"
                                   class="form-control input-md" value="{{old('searchCustomer')}}">
                        </div>
                        <div class="col-md-6">
                            <button type="button" onclick="find_customer()" class="btn btn-primary">Search Customer
                            </button>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <p id="customer_list"></p>
                </div>

                @if(null !== old('customerId'))
                    <input type="hidden" value="{{old('customerId')}}" id="customerId" name="customerId">
                @else
                    <input type="hidden" value="0" id="customerId" name="customerId">
            @endif

            <!-- Payment Method -->
                <div class="form-group {{ $errors->has('paymentMethod') ? ' has-error' : '' }}">
                    <h6>Payment</h6>
                    <label class="control-label" for="paymentMethod">Method</label>
                    <div class="radio">
                        <label for="paymentMethod-0">
                            <input type="radio" name="paymentMethod" id="paymentMethod-0" value="CARD"
                                   checked="checked">
                            Credit/Debit Card
                            <div class="{{ $errors->has('cardType') ? ' has-error' : '' }}" style="margin-top: -15px;">
                                <label class="control-label" for="cardType"></label>
                                <input id="cardType" name="cardType" type="text" placeholder="Card Type"
                                       class="form-control input-md" value="{{old('cardType')}}">
                                <p class="help-block">Format: input 2/3 characters as stated by the following: <i>VI - Visa, VDT - Visa Debit, VEL - Visa Electron, AEX - American Express, MC - Mastercard </i></p>
                            </div>
                            <div class="{{ $errors->has('creditCardNumber') ? ' has-error' : '' }}" style="margin-top: -15px;">
                                <label class="control-label" for="creditCardNumber"></label>
                                <input id="creditCardNumber" name="creditCardNumber" type="text" placeholder="16 digit Card No"
                                       class="form-control input-md" value="{{old('creditCardNumber')}}">
                            </div>

                        </label>
                    </div>
                    <div class="radio">
                        <label for="paymentMethod-1">
                            <input type="radio" name="paymentMethod" id="paymentMethod-1" value="CASH">
                            Cash
                        </label>
                    </div>
                    <div class="radio">
                        <label for="paymentMethod-2">
                            <input type="radio" name="paymentMethod" id="paymentMethod-2" value="CHEQUE">
                            Cheque
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label" for="paymentMethod">Options</label>
                    <div class="checkbox">
                        <label for="payLater">
                            <input type="checkbox" name="payLater" id="payLater" value="1">
                            Pay Later?
                        </label>
                    </div>
                </div>


                <h6>Passenger Details</h6>

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
                        <div class="col-md-6">
                            <label class="control-label" for="dateOfBirth">DOB</label>
                            <input id="dateOfBirth" name="dateOfBirth" required type="date"
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
                            <label class="control-label" for="town">Town</label>
                            <input id="town" name="town" required type="text" placeholder="Town"
                                   class="form-control input-md" value="{{old('town')}}">
                        </div>
                    </div>
                </div>

                <!-- Postal Area-->
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
                    <p class="help-block">Format: <i>+999999999999 (country code followed by number)</i></p>

                </div>

                <!-- Phone Number (Secondary)-->
                <div class="form-group {{ $errors->has('secondaryPhoneNumber') ? ' has-error' : '' }}">
                    <label class="control-label" for="secondaryPhoneNumber">Phone No.(Secondary)</label>
                    <input id="secondaryPhoneNumber" pattern='[\+]\d{2}\d{2}\d{4}\d{4}' name="secondaryPhoneNumber"
                           type="tel" placeholder="Optional Phone Number"
                           class="form-control input-md" value="{{old('secondaryPhoneNumber')}}">
                    <p class="help-block">Format: <i>+999999999999 (country code followed by number)</i></p>

                </div>


            </fieldset>

            <!-- Submit and reset buttons -->
            <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-database" aria-hidden="true"></i>
                             Record Sale</button>
                        <button type="reset" value="reset" class="btn btn-default"><i class="fa fa-undo" aria-hidden="true"></i>
                             Reset</button>
            </div>

        </form>
        @include('layouts.errors')
    </div>
    <hr>

    <script>
        var customers;
        function find_customer() {
            //document.getElementById("customer_list").innerHTML = "<table class='table'> <tr><td>Addil</td><td>Afzal</td></tr> </table>";
            var cName = $('#searchCustomer').val();
            $.post("/manager/sales/find-customer/",
                {

                    '_token': "{{csrf_token()}}",
                    name: cName
                },
                function (data, status) {
                    customers = data;
                    var tmp;
                    //$('#customer_list').toggle();
                    if (data.length > 0) {
                        if (data.length > 1) {
                            tmp = "<div class='alert alert-success'>" + data.length + " Customer Accounts Found</div> ";
                        } else {
                            tmp = "<div class='alert alert-success'>" + data.length + " Customer Account Found</div> ";
                        }
                        tmp = tmp + "<table class='table'> ";
                        tmp = tmp + "<thead><th>First Name</th><th>Surname</th><th>Date Of Birth</th><th>Postal Area</th><th></th></thead> ";
                        for (var i = 0; i < data.length; i++) {
                            tmp = tmp + "<tr><td>"
                                + data[i].Firstname + "</td><td>"
                                + data[i].Surname + "</td><td>"
                                + data[i].DateOfBirth + "</td><td>"
                                + data[i].PostalArea + "</td><td>"
                                + "<button class='btn btn-sm btn-primary' onclick='select_customer(" + data[i].id + ")' type='button' id='selectButton" + data[i].id + "'> Select</button></td></tr>";
                        }
                        tmp = tmp + "</table>";
                        document.getElementById("customer_list").innerHTML = tmp;

                    } else {
                        document.getElementById("customer_list").innerHTML = "<div class='alert alert-danger'>Customer Not Found</div> ";
                    }
                    //$('#customer_list').toggle(600);

                    //document.getElementById("customer_list").innerHTML = data + status;
                });
        }
        function select_customer(id) {
            $('#selectButton' + id).text("Selected");
            $('#selectButton' + id).prop("disabled", true);
            $('#customerId').val(id);
        }
        $('paymentMethod-0').change(function () {
            if($(this).is(':checked')) {
                $('creditCardNumber').attr('required');
            } else {
                $('creditCardNumber').removeAttr('required');
            }
        });
    </script>
@endsection
