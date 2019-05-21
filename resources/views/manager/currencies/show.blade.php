@extends('layouts.master')

@section('content')
    <div class="container">
        <h3>Currency</h3>
        <h4>{{$currency->CurrencyName}} ({{$currency->CurrencyAbbreviation}})</h4>

        @include('layouts.message')

        <table class="table">
            <tr>
                <td>
                    Name
                </td>
                <td>
                    {{$currency->CurrencyName}}
                </td>
            </tr>
            <tr>
                <td>
                    Abbreviation
                </td>
                <td>
                    {{$currency->CurrencyAbbreviation}}
                </td>
            </tr>
            <tr>
                <td>
                    USD to {{$currency->CurrencyAbbreviation}}
                </td>
                <td>
                    {{$currency->Rate}}
                </td>
            </tr>
            <tr>
                <td>
                    {{$currency->CurrencyAbbreviation}} to USD
                </td>
                <td>
                    {{round(1/$currency->Rate,5)}}
                </td>
            </tr>
            <tr>
                <td>
                    Created At
                </td>
                <td>
                    {{$currency->created_at}}
                </td>
            </tr>
            <tr>
                <td>
                    Updated At
                </td>
                <td>
                    {{$currency->updated_at}}
                </td>
            </tr>
        </table>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".update-modal"><i
                    class="fa fa-arrow-circle-o-right" aria-hidden="true"></i> Update Rate
        </button>

        <div class="modal fade update-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="/manager/currencies/update/rate" method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="gridSystemModalLabel">
                                Update Currency Rate
                            </h4>
                        </div>
                        <div class="modal-body">
                            {{csrf_field()}}
                            <div class="form-group">
                                <input type="hidden" name="id" value="{{$currency->id}}">
                                <label for="rate">Currency Rate</label>
                                <input type="text" id="rate" name="rate" class="form-control" placeholder="Rate">
                                <p class="help-block"><i>USD to Currency</i></p>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary" type="submit"><i
                                        class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>
                                Update</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <hr>





@endsection