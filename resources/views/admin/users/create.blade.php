@extends('layouts.master')

@section('content')
    <div class="container">

        <ol class="breadcrumb">
            <li><a href="/admin">Home</a></li>
            <li><a href="/admin/users">Users</a></li>
            <li class="active">Register</li>
        </ol>

        <h3>Register A User</h3>
        <h5>About the user</h5>
        <form method="post" action="/admin/users">
            {{csrf_field()}}
            <div class="form-group{{ $errors->has('inputUserName') ? ' has-error' : '' }}">
                <label for="inputUserName">Full Name</label>
                <input type="text" class="form-control" id="inputUserName" name="inputUserName" placeholder="Name" value="{{old('inputUserName')}}">
            </div>
            <div class="form-group{{ $errors->has('inputUserUsername') ? ' has-error' : '' }}">
                <label for="inputUserUsername">Username</label>
                <input type="text" class="form-control" id="inputUserUsername" name="inputUserUsername" placeholder="Username" value="{{old('inputUserUsername')}}">
            </div>
            <div class="form-group{{ $errors->has('selectRole') ? ' has-error' : '' }}">
                <label for="selectRole">Role</label>
                <select class="form-control" id="selectRole" name="selectRole">
                    <option value="" disabled selected>Select your option</option>
                    @foreach($roles as $role)
                        @if($role == old('selectRole'))
                            <option value="{{$role}}" selected>{{$role}}</option>
                        @else
                            <option value="{{$role}}">{{ucwords($role)}}</option>
                        @endif
                    @endforeach
                    <option value="f543">Wrong value</option>
                </select>
            </div>
            <div class="form-group{{ $errors->has('inputPassword') ? ' has-error' : '' }}">
                <label for="inputPassword">Password</label>
                <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="Password" value="{{old('inputPassword')}}">
                <label for="inputPassword_confirmation">Repeat Password</label>
                <input type="password" class="form-control" id="inputPassword_confirmation" name="inputPassword_confirmation" placeholder="Repeat Password" value="{{old('inputPassword_confirmation')}}">
                <p class="help-block"><button type="button" class="btn btn-sm btn-info" onclick="randomPassword()" id="passwordButton">Generate Random Password</button></p>
                <div id="password" name="password"> </div>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
        @include('layouts.errors')
    </div>
    <script>
        function randomPassword() {
            var randomstring = Math.random().toString(36).slice(-8);
            document.getElementById('password').innerHTML = "<div class='alert alert-warning alert-dismissible' role='alert' style='margin-top: 17px;'> <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button> <strong>Your Password</strong> " + randomstring + " </div>";
            $('#inputPassword').val(randomstring);
            $('#inputPassword_confirmation').val(randomstring);
        }
    </script>
    <hr>
@endsection