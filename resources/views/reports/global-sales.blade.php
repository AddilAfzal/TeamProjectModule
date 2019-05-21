<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Ticket Stock Turnover Report</title>

    <link href="/home/team/web/webscape.ml/public_html/public/report/bootstrap.css" rel="stylesheet">
    <style>
        body {
            font-size: 70%;
        }
    </style>

</head>
<body>

<h2>Global Sales Report - {{$scope}} </h2>
<h3 style="margin-top: 0px;">{{$start_period}} / {{$end_period}}</h3>

<table class="table table-bordered table-condensed">
    <tr>
        <td><b>Agent:</b> {{\App\TravelAgent::getName()}}</td>
        <td><b>Sales Office Place:</b> {{\App\TravelAgent::getAddress()->AddressLine1}},
            {{ (\App\TravelAgent::getAddress()->AddressLine2 == null) ? "" :  \App\TravelAgent::getAddress()->AddressLine2 . "," }}
            {{ (\App\TravelAgent::getAddress()->AddressLine3 == null) ? "" :  \App\TravelAgent::getAddress()->AddressLine3 . "," }}
            {{ (\App\TravelAgent::getAddress()->AddressLine4 == null) ? "" :  \App\TravelAgent::getAddress()->AddressLine4 . "," }}
            {{\App\TravelAgent::getAddress()->CityTown}},
            {{\App\TravelAgent::getAddress()->PostalArea}},
            {{\App\TravelAgent::getAddress()->GoverningDistrict}}
        </td>
    </tr>
</table>

<table class="table table-bordered table-condensed">
    <thead>
    <tr>
        <th colspan="8">
            AIR VIA DOCUMENTS
        </th>
        <th colspan="4">
            FORMS OF PAYMENT
        </th>
        <th colspan="2">
            COMMISSION
        </th>
    </tr>
    <tr>
        <th rowspan="2">
            ORIGINAL <br>ISSUED<br> NUMBER
        </th>
        <th rowspan="2">
            SUB AGENT
        </th>
        <th colspan="3">
            FARE AMOUNT
        </th>
        <th colspan="2">
            TAXES
        </th>
        <th rowspan="2">
            TOTAL<br>DOCUMENT'S<br> AMOUNT
        </th>
        <th rowspan="2">
            CASH
        </th>
        <th colspan="3">
            CREDIT CARDS
        </th>
        <th rowspan="2">
            RATE
        </th>
        <th rowspan="2">
            AMNT
        </th>
    </tr>
    <tr>
        <th>
            USD
        </th>
        <th>
            USD/CURRENCY
        </th>
        <th>
            CURRENCY
        </th>
        <th>
            LZ
        </th>
        <th>
            OTHS
        </th>
        <th>
            FULL CC NUMBER
        </th>
        <th>
            USD
        </th>
        <th>
            CURRENCY
        </th>
    </tr>

    </thead>
    <tbody>
    @foreach($blanks as $blank)
        @if($blank->sale->AwaitingPayment == 1)
        @else
            <tr>
                <td>
                    {{$blank->blank_number}}
                </td>
                <td>
                    {{$blank->user->username}}
                </td>
                <td>
                    {{ round($blank->sale->SaleFareUSD) }}
                </td>

                <td>
                    {{$blank->sale->CurrencyRate}}
                </td>
                <td>
                    {{$blank->sale->SaleFare}}
                </td>
                <td>
                    {{$blank->sale->SaleTaxLocal}}
                </td>
                <td>
                    {{$blank->sale->SaleTaxOther}}
                </td>
                <td>
                    {{$blank->sale->SaleTotal}}
                </td>
                <td>
                    @if($blank->sale->PaymentMethod == 'CASH')
                        {{$blank->sale->SaleTotal}}
                    @endif
                </td>
                <td>
                    @if($blank->sale->PaymentMethod == 'CARD')
                        {{$blank->sale->CardType}} {{ chunk_split($blank->sale->CardNumber, 4, ' ') }}
                    @endif
                </td>
                <td>
                    @if($blank->sale->PaymentMethod == 'CARD')
                        {{ round($blank->sale->SaleTotal / $blank->sale->CurrencyRate) }}
                    @endif
                </td>
                <td>
                    @if($blank->sale->PaymentMethod == 'CARD')
                        {{$blank->sale->SaleTotal}}
                    @endif
                </td>
                <td>
                    {{$blank->sale->CommissionRate}}
                </td>
                <td>
                    {{$blank->sale->SaleCommission}}
                </td>


            </tr>
        @endif
    @endforeach
    <tr>
        <th>
            NBR OF TKTS: {{$ticketsCount}}
        </th>
        <th></th>
        <th>
            {{$SaleFareUSD}}
        </th>

        {{--Empty--}}
        <th></th>

        {{--Currency Total--}}
        <th>{{ $currencyTotal }}</th>

        <th>{{$taxLocalTotal}}</th>
        <th>{{$taxOtherTotal}}</th>

        <th>{{$saleTotalTotal}}</th>
        <th>{{$cashTotal}}</th>

        <th></th>
        <th>{{$saleUSDTotal}}</th>
        <th>{{$saleTotalCurrency}}</th>


        <th></th>
        <th>{{$commissionAmountTotal}}</th>
    </tr>
    </tbody>
</table>

<p>TOTAL NET AMOUNT FOR BANK REMITTENCE TO "AIR VIA" {{$totalNet}} </p>


</body>
</html>