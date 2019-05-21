@extends('layouts.master')

@section('content')
    <div class="container">

        <ol class="breadcrumb">
            <li><a href="/manager">Home</a></li>
            <li class="active">Individual Sales</li>
        </ol>

        @include('layouts.message')
        <h3>Reports</h3>
        <h5>Individual Sales</h5>
        <form method="get" action="/manager/reports/individual-sales/show">
        {{csrf_field()}}

            <input type="hidden" name="advisorId" id="advisorId">
        <!-- Report Period -->
            <div class="form-group {{ ($errors->has('dateFrom') || $errors->has('dateTo')) ? ' has-error' : '' }}">
                <label for="inputBlankNumberFrom">Report Period</label>
                <div class="row">
                    <div class="col-md-4">
                        <input required type="date" class="form-control" id="dateFrom" name="dateFrom"
                               placeholder="From" value="{{old('dateFrom')}}">
                    </div>
                    <div class="col-md-4">
                        <input required type="date" class="form-control" id="dateTo" name="dateTo"
                               placeholder="To" value="{{old('dateTo')}}">
                    </div>
                </div>
                <p class="help-block">Select the required report period.</p>
            </div>

            <!-- Advisor Select -->
            <div class="form-group{{ $errors->has('advisor') ? ' has-error' : '' }}">
                <label for="advisor">Sales Advisor</label>
                <select class="form-control" id="advisor" name="advisor">
                    <option value="" disabled selected>Select your option</option>
                    @foreach($advisors as $advisor)
                        @if($advisor->id == old('advisor'))
                            <option value="{{$advisor->id}}" selected>
                                {{$advisor->name}}
                            </option>
                        @else
                            <option value="{{$advisor->id}}">
                                {{$advisor->name}}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>




            <!-- Report Type -->
            <div class="form-group {{ $errors->has('reportScope') ? ' has-error' : '' }}">
                <label class="control-label" for="paymentMethod">Scope</label>
                <div class="radio">
                    <label for="reportScope-0">
                        <input type="radio" name="reportScope" id="reportScope-0" value="INTERLINE">
                        Interline
                    </label>
                </div>
                <div class="radio">
                    <label for="reportScope-1">
                        <input type="radio" name="reportScope" id="reportScope-1" value="DOMESTIC">
                        Domestic
                    </label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Generate</button>
        </form>

    </div>
@endsection