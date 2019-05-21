@extends('layouts.master')

@section('content')
    <div class="container">
        <h3>Add Discount</h3>
        <h5>About the discounts</h5>
        @include('layouts.errors')
        <form method="post" action="/manager/discounts">
            {{csrf_field()}}

            <div class="form-group {{ ($errors->has('discountBand')) ? ' has-error' : '' }}">
                <label for="discountBand">Discount Band Name</label>
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="discountBand" name="discountBand"
                               placeholder="Discount Band Name" value="{{old('discountBand')}}">
                    </div>
                </div>
            </div>

            <div class="form-group{{ $errors->has('discountType') ? ' has-error' : '' }}">
                <label for="discountType">Discount Type</label>
                <div class="row">
                    <div class="col-md-4">
                <select class="form-control" id="discountType" name="discountType">
                    <option value="" disabled selected>Select your option</option>
                    <option value="FIXED" {{ old('discountType') == 'FIXED' ? 'selected' : ''  }}> Fixed
                    </option>
                    <option value="FLEXIBLE" {{ old('discountType') == 'FLEXIBLE' ? 'selected' : ''  }}> Flexible
                    </option>
                </select>
                    </div></div>
            </div>

            <div class="form-group {{ ($errors->has('discountRate')) ? ' has-error' : '' }}">

                <label for="discountRate">Discount Rate</label>
                <div class="row">
                    <div class="col-md-5">
                        <input type="text" class="form-control" id="discountRate" name="discountRate"
                               placeholder="Rate" value="{{old('discountRate')}}">
                        <p class="help-block">Note: <i>For flexible type, insert as max,rate| (e.g. 1000,0.00|2000,0.01). Otherwise define max as 0</i></p>
                    </div>
                </div>
            </div>


            <div class="form-group">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>

@endsection