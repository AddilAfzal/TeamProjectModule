@extends('layouts.master')

@section('content')
    <div class="container">

        <ol class="breadcrumb">
            <li><a href="/admin">Home</a></li>
            <li><a href="/admin/users">Users</a></li>
            <li class="active">Search</li>
        </ol>

        <h3>Search Users</h3>
        <h5>{{$message}}</h5>

        @include('layouts.message')

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