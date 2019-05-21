@extends('layouts.master')

@section('content')
    <div class="container">

        <ol class="breadcrumb">
            <li><a href="/admin">Home</a></li>
            <li><a href="/admin/blanks">Blanks</a></li>
            <li class="active">Register Blank</li>
        </ol>

        <h3>Register Blank</h3>
        <h5>About the blank/s</h5>
        <form method="post" action="/admin/blanks">
            {{csrf_field()}}

            <div class="form-group {{ ($errors->has('inputBlankNumberFrom') || $errors->has('inputBlankNumberTo')) ? ' has-error' : '' }}">
                <label for="inputBlankNumberFrom">Blank Number Range</label>
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="inputBlankNumberFrom" name="inputBlankNumberFrom"
                               placeholder="From" value="{{old('inputBlankNumberFrom')}}">
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="inputBlankNumberTo" name="inputBlankNumberTo"
                               placeholder="To" value="{{old('inputBlankNumberTo')}}">
                    </div>
                </div>
                <p class="help-block">Format: XXXXXXXX <i>(8 digits)</i> e.g 444 12345678
                    <br>If inserting individual blank, simply repeat the blank number.</p>
            </div>

            <div class="form-group{{ $errors->has('selectBlankType') ? ' has-error' : '' }}">
                <label for="selectBlankType">Blank Type</label>
                <select class="form-control" id="selectBlankType" name="selectBlankType">
                    <option value="" disabled selected>Select your option</option>
                    @foreach($types as $type)
                        @if(old('selectBlankType') == $type->id)
                            <option value="{{$type->id}}" selected>{{$type->prefix}} ({{$type->type}}) ({{$type->scope}}
                                )
                                ({{$type->number_of_coupons}})
                            </option>
                        @else
                            <option value="{{$type->id}}" data-coupons="{{$type->number_of_coupons}}">{{$type->prefix}}
                                ({{$type->type}}) ({{$type->scope}})
                                ({{$type->number_of_coupons}})
                            </option>
                        @endif


                    @endforeach
                    <option value="f543">Wrong value</option>
                </select>
                <p class="help-block">Format: <i>Prefix</i> (<i>Type</i>) (<i>Scope</i>) (<i>Coupons</i>)</p>
            </div>

            {{--<div id="coupons-container">--}}
                {{--<h5>Coupons</h5>--}}
                {{--<button type="button" class="btn btn-info btn-xs" onclick="addCouponsField()">Add Another Coupon</button>--}}
                {{--@for($i = 1; $i < 5; $i++)--}}
                    {{--<div id="coupons-{{$i}}">--}}
                        {{--<h6>Coupon {{$i}}</h6>--}}
                        {{--<div class="form-group {{ ($errors->has('flightNumber' . $i) || $errors->has('inputBlankNumberTo')) ? ' has-error' : '' }}">--}}
                            {{--<label for="flightNumber">Flight Number</label>--}}
                            {{--<input type="text" class="form-control" id="{{'flightNumber' . $i}}"--}}
                                   {{--name="flightNumber[]"--}}
                                   {{--placeholder="To" value="{{ old('flightNumber' . $i) }}">--}}
                            {{--<p class="help-block"></p>--}}
                        {{--</div>--}}
                        {{--<div class="form-group {{ ($errors->has('departureFrom') || $errors->has('departureFrom')) ? ' has-error' : '' }}">--}}
                            {{--<div class="row">--}}
                                {{--<div class="col-md-5">--}}
                                    {{--<label for="departureFrom">Departure From</label>--}}
                                    {{--<input type="text" class="form-control" id="departureFrom"--}}
                                           {{--name="departureFrom[]"--}}
                                           {{--placeholder="From" value="{{old('departureFrom')}}">--}}
                                {{--</div>--}}
                                {{--<div class="col-md-4">--}}
                                    {{--<label for="departureTime">Departure Time</label>--}}
                                    {{--<input type="datetime-local" class="form-control" id="departureTime"--}}
                                           {{--name="departureTime[]"--}}
                                           {{--placeholder="Time" value="{{old('departureTime')}}">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<p class="help-block">Format: XXX <i>(Airport Code)</i> - XXXXX.... (Airport Name +--}}
                                {{--Terminal)<br>--}}
                                {{--LHR - London Heathrow Terminal 4 </p>--}}
                        {{--</div>--}}

                        {{--<div class="form-group {{ ($errors->has('arrivalTo') || $errors->has('arrivalTo')) ? ' has-error' : '' }}">--}}
                            {{--<div class="row">--}}
                                {{--<div class="col-md-5">--}}
                                    {{--<label for="arrivalTo">Arrival To</label>--}}
                                    {{--<input type="text" class="form-control" id="arrivalTo"--}}
                                           {{--name="arrivalTo[]"--}}
                                           {{--placeholder="From" value="{{old('arrivalTo')}}">--}}
                                {{--</div>--}}
                                {{--<div class="col-md-4">--}}
                                    {{--<label for="arrivalTime">Arrival Time</label>--}}
                                    {{--<input type="datetime-local" class="form-control" id="arrivalTime"--}}
                                           {{--name="arrivalTime[]"--}}
                                           {{--placeholder="To" value="{{old('arrivalTime')}}">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<p class="help-block">Format: XXX <i>(Airport Code)</i> - XXXXX.... (Airport Name +--}}
                                {{--Terminal)<br>--}}
                                {{--LHR - London Heathrow Terminal 4 </p>--}}
                        {{--</div>--}}

                    {{--</div>--}}
                {{--@endfor--}}
            {{--</div>--}}


            <button type="submit" class="btn btn-primary">Register</button>
        </form>
        @include('layouts.errors')
    </div>
    <hr>

    <script>
        var i = 1;
        $(document).ready(function () {
            $('#coupons-1').hide();
            $('#coupons-2').hide();
            $('#coupons-3').hide();
            $('#coupons-4').hide();

            $('#coupons-container').hide();

        });

        $('#selectBlankType').change(function () {
            $('#coupons-container').show();
            var a = $(this).find(':selected').data('coupons');
            console.log(a);
            if (a == 1) {
                $('#coupons-1').show();
                $('#coupons-2').hide();
                $('#coupons-3').hide();
                $('#coupons-4').hide();
            }
            if (a == 2) {
                $('#coupons-1').show();
                $('#coupons-2').show();
                $('#coupons-3').hide();
                $('#coupons-4').hide();
            }
            if (a == 4) {
                $('#coupons-1').show();
                $('#coupons-2').show();
                $('#coupons-3').show();
                $('#coupons-4').show();
            }
        });
    </script>
@endsection