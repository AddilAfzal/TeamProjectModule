@extends('layouts.master')

@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="/manager">Home</a></li>
            <li><a href="/manager/refunds">Refunds</a></li>
            <li class="active">Record Refund</li>
        </ol>
        <h3>New Refund</h3>
        @if(count($blanks) > 0)
            <form method="post" action="/manager/refunds/">
                {{csrf_field()}}

                <fieldset>


                    <!-- Blank Number -->
                    <div class="form-group {{ $errors->has('blankId') ? ' has-error' : '' }}">
                        <label class="control-label" for="blankId">Blank Being Refunded </label>
                        <select id="blankId" name="blankId" class="form-control" required>
                            @if(!(null !== old('blankId')))
                                <option value="" disabled selected>Select Blank Number</option>
                            @endif
                            @foreach($blanks as $blank)
                                @if($blank->id == old('blankId'))
                                    <option value="{{$blank->id}}" selected> {{$blank->blank_number}}</option>
                                @else
                                    <option value="{{$blank->id}}"> {{$blank->blank_number}}</option>
                                @endif
                            @endforeach
                        </select>

                    </div>

                    <!-- Refund Amount -->
                    <div class="form-group {{ $errors->has('refundAmount') ? ' has-error' : '' }}">
                        <label class="control-label" for="refundAmount">Amount to Refund</label>
                        <input id="refundAmount" name="refundAmount" class="form-control" placeholder="Amount"
                               value="{{old('refundAmount')}}"
                               required/>
                    </div>

                    <!-- Refund Method -->
                    <div class="form-group {{ $errors->has('refundMethod') ? ' has-error' : '' }}">
                        <label class="control-label" for="refundMethod">Refund Method</label>
                        <div class="radio">
                            <label for="refundMethod-0">
                                @if(old('refundMethod') == 'CARD')
                                    <input type="radio" name="refundMethod" id="refundMethod-0" value="CARD"
                                           checked>
                                @else
                                    <input type="radio" name="refundMethod" id="refundMethod-0" value="CARD">
                                @endif
                                    Credit/Debit Card

                            </label>
                        </div>
                        <div class="radio">
                            <label for="refundMethod-1">
                                @if(old('refundMethod') == 'CASH')
                                    <input type="radio" name="refundMethod" id="refundMethod-1" value="CASH" checked>
                                @else
                                    <input type="radio" name="refundMethod" id="refundMethod-1" value="CASH">
                                @endif
                                Cash
                            </label>
                        </div>
                        <div class="radio">
                            <label for="refundMethod-2">
                                @if(old('refundMethod') == 'CHEQUE')
                                    <input type="radio" name="refundMethod" id="refundMethod-2" value="CHEQUE" checked>
                                @else
                                    <input type="radio" name="refundMethod" id="refundMethod-2" value="CHEQUE">
                                @endif
                                Cheque
                            </label>
                        </div>
                    </div>

                    <!-- Refund Reason -->
                    <div class="form-group {{ $errors->has('refundReason') ? ' has-error' : '' }}">
                        <label class="control-label" for="refundReason">Reason for Refund</label>
                        <textarea id="refundReason" name="refundReason" class="form-control" placeholder="Reason"
                                  required>{{old('refundReason')}}</textarea>
                    </div>

                </fieldset>


                <button type="submit" class="btn btn-primary">Record</button>
            </form>

            @include('layouts.errors')
        @else
            <div class="alert alert-warning">
                <h6>Notice</h6>
                <p>There aren't any blanks available to be refunded.</p>
            </div>
        @endif
    </div>
    <hr>
@endsection