@extends('layouts.master')

@section('content')
    <div class="container">

        <ol class="breadcrumb">
            <li><a href="/manager/">Home</a></li>
            <li><a href="/manager/customers">Customers</a></li>
            <li><a href="/manager/customers/{{$customer->id}}"> {{$customer->Firstname}} {{$customer->Surname}}</a></li>
            <li class="active">Reminder Letter</li>
        </ol>

        <h3>{{$customer->Firstname}} {{$customer->Surname}}</h3>
        <h5>Payment Reminder Letter</h5>

        @include('layouts.message')

        <button type="button" onclick="printPDF()" class="btn btn-primary"><i class="fa fa-print" aria-hidden="true"></i>
             Print Letter</button>
        <button type="button" class="btn btn-extra-1" data-toggle="modal" data-target=".log-modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
             Log Payment Reminder </button>
        <hr>
        <div id="letter">
            <embed id="pdfDocument" src="/manager/customers/{{$customer->id}}/payment-letter-get" width="800px" height="900px" style="border: 1px solid #eee;" type="application/pdf"
                   />

        </div>

        <!-- Log Letter Sent Action -->

        <div class="modal fade log-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="/manager/customers/log/payment-reminder" method="post">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="gridSystemModalLabel">Log Payment Letter Confirmation</h4>
                        </div>

                        <div class="modal-body">
                            {{csrf_field()}}
                            <div class="form-group">
                                <input type="hidden" name="customerId" value="{{$customer->id}}">
                                <p>Are you sure that you would like to log that a new payment reminder letter has been sent to this customer?</p>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button class="btn btn-extra-1" type="submit"><i class="fa fa-pencil-square-o"
                                                                            aria-hidden="true"></i> Log Payment Reminder
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <hr>
    </div>

    <script>
        function printDocument() {
            var documentId = 'pdfDocument';
            var doc = document.getElementById(documentId);

            //Wait until PDF is ready to print
            if (typeof doc.print === 'undefined') {
                setTimeout(function () {
                    printDocument(documentId);
                }, 1000);
            } else {
                doc.print();
            }
        }

        function printPDF()
        {
            var w = window.open('/manager/customers/{{$customer->id}}/payment-letter-get/' );
            w.print();
        }

    </script>

@endsection