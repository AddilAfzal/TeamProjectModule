@extends('layouts.master')

@section('content')
    <div class="container">

        <ol class="breadcrumb">
            <li><a href="/admin">Home</a></li>
            <li><a href="/admin/currencies">Currencies</a></li>
            <li class="active">Create</li>
        </ol>

        <h3>Create A Currency</h3>
        <h5>About the currency</h5>
        <form method="post" action="/admin/currencies/store">
            {{csrf_field()}}
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="United States Dollar" value="{{old('name')}}">
            </div>
            <div class="form-group{{ $errors->has('abbreviation') ? ' has-error' : '' }}">
                <label for="abbreviation">Abbreviation</label>
                <input type="text" class="form-control" id="abbreviation" name="abbreviation" placeholder="USD" value="{{old('abbreviation')}}">
            </div>
            <div class="form-group{{ $errors->has('currentRate') ? ' has-error' : '' }}">
                <label for="currentRate">Current Rate</label>
                <input pattern="^([0-9]{1,5}(\.[0-9]{1,4})?)$" type="text" class="form-control" id="currentRate" name="currentRate" placeholder="1.34" value="{{old('currentRate')}}">
                <p class="help-block">Format: <i>XXXXX.YYYY</i></p>
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
        </form>
        @include('layouts.errors')
    </div>
    <hr>
@endsection