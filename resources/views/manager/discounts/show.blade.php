@extends('layouts.master')

@section('content')
    <div class="container">
        <h3>Discount</h3>
        <h5>Band {{$discount->band}}</h5>

        @include('layouts.message')

        <table class="table table-bordered">
            <tr>
                <td>
                    <b>Discount Type:</b>
                </td>
                <td>
                    {{$discount->type}}
                </td>
            </tr>
            <tr>
                <td>
                    <b>Discount Rate:</b>
                </td>
                <td>
                    {{$discount->rate}}
                </td>
            </tr>
            <tr>
                <td>
                    <b>Created At:</b>
                </td>
                <td>
                    {{$discount->created_at}}
                </td>
            </tr>
            <tr>
                <td>
                    <b>Updated At:</b>
                </td>
                <td>
                    {{$discount->updated_at}}
                </td>
            </tr>
        </table>

        <br>
        <h5>Customers on this Plan</h5>
        <h6>{{count(\App\Customer::where('discount_id', $discount->id)->get())}} found to be on this plan.</h6>
        <table class="table table-bordered">
            <thead>
            <th>Title</th>
            <th>First Name</th>
            <th>Surname</th>
            <th>DOB</th>
            </thead>

            @foreach(\App\Customer::where('discount_id', $discount->id)->get() as $customer)
                <tr>
                    <td>{{$customer->Title}}</td>
                    <td><a href="/manager/customers/{{$customer->id}}">{{$customer->Firstname}}</a></td>
                    <td>{{$customer->Surname}}</td>
                    <td>{{$customer->DateOfBirth}}</td>
                </tr>
            @endforeach
        </table>

        <br>


        <h5>Options</h5>

        <!-- Change Acount Type Action -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".update-type-modal"><i
                    class="fa fa-bars" aria-hidden="true"></i> Assign Customer
        </button>

        <div class="modal fade update-type-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="/manager/discounts/assign-customer/" method="post">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="gridSystemModalLabel">
                                Assign Customer</h4>
                        </div>
                        <div class="modal-body">
                            {{csrf_field()}}
                            <div class="form-group">
                                <input type="hidden" name="discountId" value="{{$discount->id}}">
                                <label for="customerType">Customer Account Type</label>
                                <select class="form-control" id="customerId" name="customerId" required>
                                    <option value="" disabled="" selected=""><i>Please Select...</i></option>
                                    @foreach(\App\Customer::where('Type', 'VALUED')->get() as $customer)
                                        <option value="{{$customer->id}}">{{ title_case($customer->Firstname) }} {{ title_case($customer->Surname)}}</option>
                                    @endforeach
                                </select>
                                <p class="help-block">This list contains customer accounts that are marked as valued.</p>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary" type="submit"><i
                                        class="fa fa-bars" aria-hidden="true"></i>
                                Assign
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Action -->
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target=".delete-modal"><i
                    class="fa fa-trash-o" aria-hidden="true"></i> Delete
        </button>

        <div class="modal fade delete-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="/manager/discounts/delete/" method="post">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="gridSystemModalLabel">Delete Confirmation</h4>
                        </div>

                        <div class="modal-body">
                            {{csrf_field()}}
                            <div class="form-group">
                                <input type="hidden" name="discountId" value="{{$discount->id}}">
                                <p>Are you sure that you would like to delete this discount band ?</p>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button class="btn btn-danger" type="submit"><i class="fa fa-trash-o"
                                                                            aria-hidden="true"></i> Delete
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <hr>
    </div>

@endsection