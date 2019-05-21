@extends('layouts.master')

@section('content')
    <div class="container">

        <ol class="breadcrumb">
            <li><a href="/manager/">Home</a></li>
            <li><a href="/manager/customers">Reports</a></li>
            <li><a href="/manager/customers">Individual Sales</a></li>
            <li class="active">Show</li>
        </ol>

        <h3>Report</h3>
        <h5>Individual Sales</h5>

        @include('layouts.message')

        <button type="button" onclick="printPDF()" class="btn btn-primary"><i class="fa fa-print" aria-hidden="true"></i>
            Print Report</button>
        <hr>
        <div id="letter">
            <embed id="pdfDocument" src="{{$link}}" width="100%" height="900px" style="border: 1px solid #eee;" type="application/pdf"
            />

        </div>

        <hr>
    </div>
    {{$link}}

    <script >
        var getUrlParameter = function getUrlParameter(sParam) {
            var sPageURL = decodeURIComponent(window.location.search.substring(1)),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : sParameterName[1];
                }
            }
        };
        function printPDF()
        {
            var a = '{{$link}}';
            var w = window.open('/advisor/reports/individual-sales/pdf?dateFrom=' + getUrlParameter('dateFrom') + '&dateTo=' + getUrlParameter('dateTo') + '&reportScope=' + getUrlParameter('reportScope'));
            w.print();
        }

    </script>

@endsection