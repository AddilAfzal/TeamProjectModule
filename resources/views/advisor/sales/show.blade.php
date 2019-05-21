@extends('layouts.master')

@section('content')
    <div class="container">

        <ol class="breadcrumb">
            <li><a href="/advisor">Home</a></li>
            <li><a href="/advisor/sales">Sales</a></li>
            <li class="active">Sale Details : {{$sale->SaleRef}}</li>
        </ol>

        @if($sale->AwaitingPayment == '1')
            <div class="alert alert-dismissable alert-warning">
                <b>Notice</b>
                <p>This sale is due a payment.</p>
            </div>
        @endif

        @if(count($sale->refund))
            <div class="alert alert-dismissable alert-warning">
                <b>Notice</b>
                <p>This sale has been refunded.</p>
            </div>
        @endif

        <h3>Sale Details</h3>
        <table class="table table-bordered">

            <tr>
                <td width="30%">Sale Reference</td>
                <td>{{$sale->SaleRef}}</td>
            </tr>
            <tr>
                <td width="30%">Blank Number</td>
                <td>{{$sale->blank->blank_number}}</td>
            </tr>
            <tr>
                <td>Advisor</td>
                <td>{{$sale->advisor->name}}</td>
            </tr>
            <tr>
                <td>Customer</td>
                <td>
                    <a href="/advisor/customers/{{$sale->customer->id}}">{{$sale->customer->Firstname}} {{$sale->customer->Surname}}</a>
                </td>
            </tr>
            <tr>
                <td>Date/Time</td>
                <td>{{$sale->SaleTime}}</td>
            </tr>
        </table>

        <h5>Sale</h5>
        <table class="table table-bordered">

            <tr>
                <td width="30%">Currency</td>
                <td>{{$sale->currency->CurrencyName}}</td>
            </tr>
            <tr>
                <td>Fare</td>
                <td>{{$sale->SaleFare}}</td>
            </tr>
            <tr>
                <td>Fare  USD</td>
                <td>{{$sale->SaleFareUSD}}</td>
            </tr>
            <tr>
                <td>Total</td>
                <td>{{$sale->SaleTotal}}</td>
            </tr>
        </table>

        <h5>Tax</h5>
        <table class="table table-bordered">
            <tr>
                <td width="30%">Local</td>
                <td>{{$sale->SaleTaxLocal}}</td>
            </tr>
            <tr>
                <td>Other</td>
                <td>{{$sale->SaleTaxOther}}</td>
            </tr>
        </table>

        <h5>Commission</h5>
        <table class="table table-bordered">
            <tr>
                <td width="30%">Amount</td>
                <td>{{$sale->SaleCommission}}</td>
            </tr>
            <tr>
                <td>Rate</td>
                <td>{{$sale->CommissionRate*100}}%</td>
            </tr>

        </table>

        <h5>Discount</h5>
        <table class="table table-bordered">
            @if($sale->DiscountType == "NONE")
                <tr>
                    <td width="30%">Discount Type</td>
                    <td>NONE</td>
                </tr>
                <tr>
                    <td width="30%">Discount Amount</td>
                    <td>-</td>
                </tr>

            @else
                <tr>
                    <td width="30%">Discount Type</td>
                    <td>{{$sale->DiscountType}}</td>
                </tr>
                <tr>
                    <td>Discount Amount</td>
                    <td>{{$sale->DiscountAmount}}</td>
                </tr>

            @endif
        </table>


        <h5>Payment</h5>
        <table class="table table-bordered">
            @if($sale->AwaitingPayment == "1")
                <tr>
                    <td width="30%">Awaiting Payment</td>
                    <td>Yes</td>
                </tr>
                <tr>

                    <td width="30%">Payment Method</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>Payment Time</td>
                    <td>-</td>
                </tr>
            @else
                <tr>
                    <td width="30%">Awaiting Payment</td>
                    <td>No</td>
                </tr>
                <tr>
                    <td>Payment Method</td>
                    <td>{{$sale->PaymentMethod}}</td>
                </tr>
                <tr>
                    <td>Payment Time</td>
                    <td>{{$sale->PaymentTime}}</td>
                </tr>

            @endif
        </table>

        <!-- Assign Action -->
        @if($sale->AwaitingPayment == 1)
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".assign-modal"><i
                        class="fa fa-arrow-circle-o-right" aria-hidden="true"></i> Update Payment Method
            </button>


            <div class="modal fade assign-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="/advisor/sales/{{$sale->id}}/" method="post">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="gridSystemModalLabel">
                                    @if($sale->AwaitingPayment == 1)
                                        Update Payment Method
                                    @endif
                                </h4>
                            </div>
                            <div class="modal-body">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <input type="hidden" name="paymentMethod" value="{{$sale->PaymentMethod}}">
                                    <label for="paymentMethod">Payment Method</label>
                                    <select class="form-control" id="paymentMethod" name="paymentMethod" required>
                                        <option value="" disabled="" selected="">Select Payment Method</option>

                                            <option value="CASH">Cash</option>
                                            <option value="CARD">Credit Card</option>
                                            <option value="CHEQUE">Cheque</option>

                                    </select>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button class="btn btn-primary" type="submit"><i
                                            class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>
                                    Update Payment Status
                                </button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>

@endsection