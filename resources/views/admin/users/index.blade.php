@extends('layouts.master')

@section('content')
    <div class="container">

        <ol class="breadcrumb">
            <li><a href="/admin">Home</a></li>
            <li class="active">Users</li>
        </ol>

        <h3>Users</h3>

        @include('layouts.message')

        <div class="row">
            <div class="col-md-8">
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" type="button">All <span
                                class="caret"></span></button>
                    <ul role="menu" class="dropdown-menu">
                        <li><a href="#" class="active">All</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Assigned</a></li>
                        <li><a href="#">Non-Assigned</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Sold</a></li>
                    </ul>
                </div>
                <a class="btn btn-info" type="button" href="users/create"><i class="fa fa-plus" aria-hidden="true"></i>
                    Register</a>
            </div><!-- /.col-lg-6 -->
            <div class="col-md-4">
                <form method="post" action="/admin/users/search">
                    <div class="input-group">
                        {{csrf_field()}}
                        <input id="name" name="name" type="text" class="form-control" placeholder="Name..." required>
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">Search</button>
                        </span>
                    </div><!-- /input-group -->
                </form>
            </div><!-- /.col-lg-6 -->
        </div><!-- /.col-lg-6 -->

        <table class="table">
            <thead>
            <th>Name</th>
            <th>Username</th>
            <th>Role</th>
            </thead>

            @foreach($users as $user)
                <tr>
                    <td><a href="/admin/users/{{$user->id}}"> {{$user->name}}</a></td>
                    <td>{{$user->username}}</td>
                    <td>{{$user->role}}</td>
                </tr>
            @endforeach

        </table>
    </div>
@endsection