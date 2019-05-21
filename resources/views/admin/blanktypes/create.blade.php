@extends('layouts.master')

@section('content')
    <div class="container">

        <ol class="breadcrumb">
            <li><a href="/admin">Home</a></li>
            <li><a href="/admin/blanktypes">Blank Types</a></li>
            <li class="active">Create Blank Type</li>
        </ol>

        <h3>Create A Blank Type</h3>
        <h5>About the blank type</h5>
        <form method="post" action="/admin/blanktypes/">
            {{csrf_field()}}
            <div class="form-group{{ $errors->has('inputBlankTypeNumber') ? ' has-error' : '' }}">
                <label for="inputBlankTypeNumber">Blank Type Prefix</label>
                <input type="text" class="form-control" id="inputBlankTypeNumber" name="inputBlankTypeNumber"
                       placeholder="Blank Type Prefix" value="{{old('inputBlankTypeNumber')}}">
                <p class="help-block">Three digit code</p>
            </div>
            <div class="form-group{{ $errors->has('selectBlankSubType') ? ' has-error' : '' }}">
                <label for="selectBlankSubType">Blank Sub Type</label>
                <select class="form-control" id="selectBlankSubType" name="selectBlankSubType">
                    <option value="" disabled selected>Select your option</option>
                    @foreach($subTypes as $type)
                        @if($type == old('selectBlankSubType'))
                            <option value="{{$type}}" selected>
                                {{$type}}
                            </option>
                        @else
                            <option value="{{$type}}">
                            {{$type}}
                            </option>
                        @endif
                    @endforeach
                    <option value="f543">Wrong value</option>
                </select>
            </div>
            <div class="form-group{{ $errors->has('selectBlankScope') ? ' has-error' : '' }}">
                <label for="selectBlankScope">Blank Scope</label>
                <select class="form-control" id="selectBlankScope" name="selectBlankScope">
                    <option value="" disabled selected>Select your option</option>
                    @foreach($scopes as $scope)
                        @if($scope == old('selectBlankScope'))
                            <option value="{{$scope}}" selected>
                                {{$scope}}
                            </option>
                        @else
                            <option value="{{$scope}}">
                                {{$scope}}
                            </option>
                        @endif
                    @endforeach
                    <option value="f543">Wrong value</option>
                </select>
            </div>
            <div class="form-group{{ $errors->has('inputCommissionRate') ? ' has-error' : '' }}">
                <label for="inputCommissionRate">Commission Rate</label>
                <input type="text" class="form-control" id="inputCommissionRate" name="inputCommissionRate"
                       placeholder="Commission Rate" value="{{old('inputCommissionRate')}}">
                <p class="help-block">As a decimal: e.g, 0.4</p>
            </div>
            <div class="form-group{{ $errors->has('inputNumberOfCoupons') ? ' has-error' : '' }}">
                <label for="inputNumberOfCoupons">Number of Coupons</label>
                <input type="text" class="form-control" id="inputNumberOfCoupons" name="inputNumberOfCoupons"
                       placeholder="Coupons Count" value="{{old('inputNumberOfCoupons')}}">
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
        @include('layouts.errors')
    </div>
    <hr>
    @include('layouts.message')
@endsection