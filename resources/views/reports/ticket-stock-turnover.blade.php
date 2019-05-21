<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Ticket Stock Turnover Report</title>

    <link href="/home/team/web/webscape.ml/public_html/public/report/bootstrap.css" rel="stylesheet">

</head>
<body>

<h2>Ticket Stock Turnover Report</h2>
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

<h3>Recieved Blanks</h3>
<div class="row">
    <div class="col-xs-5">

        <h4>Agent's Stock </h4>
        <table class="">
            <thead>
            <tr>
                <th>
                    FROM/TO BLANKS NBRS
                </th>
                <th>
                    AMNT
                </th>
            </tr>

            </thead>

            <tbody>
            @foreach($blanksReceived_agentsStock as $data)
                <tr>
                    <td>
                        {{$data->min}} - {{$data->max}}
                    </td>
                    <td>
                        {{$data->count}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-xs-6">
        <h4>Sub Agent's Stock</h4>
        <table class="">
            <thead>
            <tr>
                <th>
                    CODE
                </th>
                <th>
                    FROM/TO BLANKS NBRS
                </th>
                <th>
                    AMNT
                </th>
            </tr>

            </thead>
            <tbody>
            @foreach($blanksReceived_subAgentsStock as $data)
                <tr>
                    <td>
                        {{$data->code}}
                    </td>
                    <td>
                        {{$data->min}} - {{$data->max}}
                    </td>
                    <td>
                        {{$data->count}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<hr>
<h3>Assigned/Used Blanks</h3>
<div class="row">
    <div class="col-xs-5">
        <h4>Sub Agents' - Assigned</h4>
        <table class="">
            <thead>
            <tr>
                <th>
                    CODE
                </th>
                <th>
                    ASSIGNED (FROM/TO)
                </th>
                <th>
                    AMNT
                </th>
            </tr>

            </thead>
            <tbody>
            @foreach($assignedUsedBlanks_assigned as $data)
                <tr>
                    <td>
                        {{$data->code}}
                    </td>
                    <td>
                        {{$data->min}} - {{$data->max}}
                    </td>
                    <td>
                        {{$data->count}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-xs-5">
        <h4>Sub Agents' - Used</h4>
        <table class="">
            <thead>
            <tr>
                <th>
                    ASSIGNED (FROM/TO)
                </th>
                <th>
                    AMNT
                </th>
            </tr>

            </thead>
            <tbody>
            @foreach($assignedUsedBlanks_assigned as $data)
                <tr>
                    <td>
                        {{$data->min}} - {{$data->max}}
                    </td>
                    <td>
                        {{$data->count}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<hr>
<h3>Final Amounts</h3>
<div class="row">
    <div class="col-xs-5">
        <h4>Agent's Ammount</h4>
        <table class="">
            <thead>
            <tr>
                <th>
                    FROM/TO
                </th>
                <th>
                    AMNT
                </th>
            </tr>

            </thead>
            <tbody>
            @foreach($finalAmounts_agentsAmmount as $data)
                <tr>
                    <td>
                        {{$data->min}} - {{$data->max}}
                    </td>
                    <td>
                        {{$data->count}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-xs-6">
        <h4>Sub Agents' Amounts</h4>
        <table class="">
            <thead>
            <tr>
                <th>
                    CODE
                </th>
                <th>
                    ASSIGNED (FROM/TO)
                </th>
                <th>
                    AMNT
                </th>
            </tr>

            </thead>
            <tbody>
            @foreach($finalAmounts_subAgentsAmmount as $data)
                <tr>
                    <td>
                        {{$data->code}}
                    </td>
                    <td>
                        {{$data->min}} - {{$data->max}}
                    </td>
                    <td>
                        {{$data->count}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>


</body>
</html>