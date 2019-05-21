@extends('layouts.master')

@section('content')
    <div class="container">

        <ol class="breadcrumb">
            <li><a href="/admin">Home</a></li>
            <li><a href="/admin/travelagent">Travel Agent</a></li>
            <li class="active">Edit Details</li>
        </ol>

        <h3>Edit Travel Agent Details</h3>
        <h5>About the travel agent</h5>
        <form class="form-horizontal" method="post" action="/admin/travelagent/">
            <fieldset>
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-4">
                        <h6>Name</h6>

                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="name">Name</label>
                    <div class="col-md-4">
                        <input id="name" name="name" type="text" placeholder="Example Agent"
                               class="form-control input-md" required="" value="{{$name}}">

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-4">
                        <h6>Address</h6>

                    </div>
                </div>
                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="AddressLine1">Address Line 1</label>
                    <div class="col-md-4">
                        <input id="AddressLine1" name="AddressLine1" type="text" placeholder="101 Example Road"
                               class="form-control input-md" required="" value="{{$address->AddressLine1}}">

                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="AddressLine2">Address Line 2</label>
                    <div class="col-md-4">
                        <input id="AddressLine2" name="AddressLine2" type="text" placeholder="" class="form-control input-md" value="{{$address->AddressLine2}}">

                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="AddressLine3">Address Line 3</label>
                    <div class="col-md-4">
                        <input id="AddressLine3" name="AddressLine3" type="text" placeholder="" class="form-control input-md" value="{{$address->AddressLine3}}">

                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="AddressLine4">Address Line 4</label>
                    <div class="col-md-4">
                        <input id="AddressLine4" name="AddressLine4" type="text" placeholder="" class="form-control input-md" value="{{$address->AddressLine4}}">

                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="CityTown">City / Town</label>
                    <div class="col-md-3">
                        <input id="CityTown" name="CityTown" type="text" placeholder="City / Town"
                               class="form-control input-md" required="" value="{{$address->CityTown}}">

                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="PostalArea">Postal Area</label>
                    <div class="col-md-2">
                        <input id="PostalArea" name="PostalArea" type="text" placeholder="EX1 2MP"
                               class="form-control input-md" required="" value="{{$address->PostalArea}}">

                    </div>
                </div>

                <!-- Text input-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="GoverningDistrict">Governing District</label>
                    <div class="col-md-4">
                        <input id="GoverningDistrict" name="GoverningDistrict" type="text" placeholder="Country / State"
                               class="form-control input-md" required="" value="{{$address->GoverningDistrict}}">

                    </div>
                </div>


                <div class="row">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-4">
                        <h6>Contact Number</h6>

                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="governing">Contact Number</label>
                    <div class="col-md-4">
                        <input id="phoneNumber" name="phoneNumber" type="text" placeholder="Phone"
                               class="form-control input-md" required="" value="{{$phone}}">
                        <p class="help-block">Remember to include your international country code (+44, etc...)</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-4">
                        <h6>Local Currency</h6>

                    </div>
                </div>

                <!-- Select Basic -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="localCurrency">Local Currency</label>
                    <div class="col-md-4">
                        <select id="localCurrency" name="localCurrency" class="form-control">
                            @foreach(\App\Currency::getAllCurrencies() as $currency)
                                @if($currency->id == \App\TravelAgent::getLocalCurrency())
                                    <option value="{{$currency->id}}" selected>{{$currency->CurrencyName}}
                                        ({{$currency->CurrencyAbbreviation}})
                                    </option>
                                @else
                                    <option value="{{$currency->id}}">{{$currency->CurrencyName}}
                                        ({{$currency->CurrencyAbbreviation}})
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Button -->
                <div class="form-group">
                    <label class="col-md-4 control-label" for=""></label>
                    <div class="col-md-4">
                        <button id="" name="" class="btn btn-primary">Update</button>
                    </div>
                </div>

            </fieldset>
        </form>

        @include('layouts.errors')
    </div>
    <hr>
    @include('layouts.message')
@endsection