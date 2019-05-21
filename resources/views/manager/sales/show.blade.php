@extends('layouts.master')

@section('content')
    <div class="container">

        <ol class="breadcrumb">
            <li><a href="/manager">Home</a></li>
            <li><a href="/manager/sales">Sales</a></li>
            <li class="active">Sale Details : {{$sale->SaleRef}}</li>
        </ol>

        @if(count($sale->refund))
            <div class="alert alert-dismissable alert-warning">
                <b>Notice</b>
                <p>This sale has been refunded.</p>
            </div>
        @endif

        @include('layouts.message')
        @include('layouts.errors')

        <h3>Sale Details</h3>
        <table class="table table-bordered">

            <tr>
                <td width="30%">Sale Reference</td>
                <td>{{$sale->SaleRef}}</td>
            </tr>
            <tr>
                <td width="30%">Blank Number</td>
                <td>
                    <a href="/manager/blanks/{{$sale->blank->id}}">{{$sale->blank->blank_number}}</a>
                </td>
            </tr>
            <tr>
                <td>Advisor</td>
                <td>{{$sale->advisor->name}}</td>
            </tr>
            <tr>
                <td>Customer</td>
                <td>
                    <a href="/manager/customers/{{$sale->customer->id}}">{{$sale->customer->Firstname}} {{$sale->customer->Surname}}</a>
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
                    <td>Discount Amount</td>
                    <td>-</td>
                </tr>

            @else
                <tr>
                    <td width="30%">Discount Type</td>
                    <td>{{ title_case($sale->DiscountType)}}</td>
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
                    <td>{{ title_case($sale->PaymentMethod)}}</td>
                </tr>
                @if($sale->PaymentMethod == 'CARD')
                    <tr>
                        <td>Credit Card Number </td>
                        <td>**** **** **** {{ substr($sale->CardNumber, 12)}}</td>
                    </tr>
                    <tr>
                        <td>Credit Card Type </td>
                        <td>{{ $sale->CardType }}</td>
                    </tr>
                @endif

                <tr>
                    <td>Payment Time</td>
                    <td>{{$sale->PaymentTime}}</td>
                </tr>

            @endif
        </table>

        <!-- Assign Action -->
        @if($sale->AwaitingPayment == 1)
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".update-payment-modal"><i
                        class="fa fa-arrow-circle-o-right" aria-hidden="true"></i> Update Payment Method
            </button>


            <div class="modal fade update-payment-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="/manager/sales/update/payment/" method="post">
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
                                    <input type="hidden" name="id" value="{{$sale->id}}">
                                    <label for="paymentMethod">Payment Method</label>
                                    <select class="form-control" id="paymentMethod" name="paymentMethod" required>
                                        <option value="" disabled="" selected="">Select Payment Method</option>

                                        <option value="CASH">Cash</option>
                                        <option value="CARD">Credit Card</option>
                                        <option value="CHEQUE">Cheque</option>

                                    </select>
                                </div>
                                <div id='formCard' class="form-group">
                                    <label for="creditCard">Card Number</label>
                                    <input class="form-control" id="creditCard" name="creditCard" required>
                                </div>
                                <div id='formCard1' class="form-group">
                                    <label for="cardType">Card Type</label>
                                    <input class="form-control" id="cardType" name="cardType" required>
                                    <p class="help-block"><i>e.g. MC, VI, VD, etc...</i></p>
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


        <hr>
    </div>

    <script>
        $('#formCard').hide();
        $('#formCard1').hide();
        $('#paymentMethod').change(function () {
            var a = $(this).find(':selected').text();
            //console.log(a);
            if (a == 'Credit Card') {
                $("#creditCard").prop('required', true);
                $('#formCard').show();
                $('#formCard1').show();
            } else {
                $("#creditCard").prop('required', false);
                $('#formCard').hide();
                $('#formCard1').hide();
            }
        });
    </script>

@endsection