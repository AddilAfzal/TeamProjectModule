@extends('layouts.master')

@section('content')
    <div class="container">

        <ol class="breadcrumb">
            <li><a href="/admin">Home</a></li>
            <li><a href="/admin/users">Users</a></li>
            <li class="active">Details</li>
        </ol>

        <h3>User Details</h3>
        <h5>{{$user->name}}</h5>

        <table class="table">
            <tr>
                <td>
                    Name:
                </td>
                <td>
                    {{$user->name}}
                </td>
            </tr>
            <tr>
                <td>
                    Username:
                </td>
                <td>
                    {{$user->username}}
                </td>
            </tr>
            <tr>
                <td>
                    Role:
                </td>
                <td>
                    {{$user->role}}
                </td>
            </tr>
            <tr>
                <td>
                    Account Status:
                </td>
                <td>
                    @if($user->isSuspended)
                        <span class="label label-warning">Suspended</span>
                    @else
                        <span class="label label-success">Active</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td>
                    Created:
                </td>
                <td>
                    {{$user->created_at}}
                </td>
            </tr>
        </table>

        <h5>Options</h5>

        <!-- Reset Password Action -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".reset-password-modal">
            <i class="fa fa-refresh" aria-hidden="true"></i>
            Reset Password
        </button>

        <div class="modal fade reset-password-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="/admin/users/resetpassword/" method="post">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="gridSystemModalLabel">Reset Confirmation</h4>
                        </div>

                        <div class="modal-body">
                            {{csrf_field()}}
                            <div class="form-group">
                                <input type="hidden" name="user_id" value="{{$user->id}}">
                                <p>Are you sure that you would like to reset the password for this user account?</p>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary" type="submit"><i class="fa fa-refresh"
                                                                             aria-hidden="true"></i> Reset Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    @if($user->isSuspended)
        <!-- Activate Action -->
            <button type="button" class="btn btn-warning" data-toggle="modal" data-target=".activate-modal"><i
                        class="fa fa-play" aria-hidden="true"></i> Reactivate
            </button>

            <div class="modal fade activate-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="/admin/users/activate/" method="post">

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="gridSystemModalLabel">Activation Confirmation</h4>
                            </div>

                            <div class="modal-body">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <input type="hidden" name="user_id" value="{{$user->id}}">
                                    <p>Are you sure that you would like to reactivate this user account? This will
                                        reinstate all user privileges. </p>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button class="btn btn-warning" type="submit"><i class="fa fa-play"
                                                                                 aria-hidden="true"></i> Reactive
                                </button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
    @else
        <!-- Suspend Action -->
            <button type="button" class="btn btn-warning" data-toggle="modal" data-target=".suspend-modal"><i
                        class="fa fa-pause" aria-hidden="true"></i> Suspend
            </button>

            <div class="modal fade suspend-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="/admin/users/suspend/" method="post">

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="gridSystemModalLabel">Suspension Confirmation</h4>
                            </div>

                            <div class="modal-body">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <input type="hidden" name="user_id" value="{{$user->id}}">
                                    <p>Are you sure that you would like to suspend this user account? This will prohibit
                                        the user from logging into the system.</p>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button class="btn btn-warning" type="submit"><i class="fa fa-pause"
                                                                                 aria-hidden="true"></i> Suspend
                                </button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
    @endif

    <!-- Delete Action -->
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target=".delete-modal"><i
                    class="fa fa-trash-o" aria-hidden="true"></i> Delete
        </button>

        <div class="modal fade delete-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="/admin/users/delete/" method="post">

                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="gridSystemModalLabel">Delete Confirmation</h4>
                        </div>

                        <div class="modal-body">
                            {{csrf_field()}}
                            <div class="form-group">
                                <input type="hidden" name="user_id" value="{{$user->id}}">
                                <p>Are you sure that you would like to delete this user account?</p>
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

        @include('layouts.message')

    </div>
@endsection