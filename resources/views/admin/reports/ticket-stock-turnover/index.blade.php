@extends('layouts.master')

@section('content')
    <div class="container">

        <ol class="breadcrumb">
            <li><a href="/admin">Home</a></li>
            <li class="active">Ticket Stock Turnover Report</li>
        </ol>

        @include('layouts.message')
        <h3>Reports</h3>
        <h5>Ticket Stock Turnover</h5>

        <form method="post" action="/admin/reports/ticket-stock-turnover/">
            {{csrf_field()}}

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

            <button type="submit" class="btn btn-primary">Generate</button>
        </form>

    </div>
@endsection