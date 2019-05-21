@extends("layouts.master")

@section('content')
    <div class="container">

        @include('layouts.message')

        <form class="form-signin" method="post" action="/login">
            {{csrf_field()}}
            <h3 class="form-signin-heading">Please log in</h3>
            <label for="username" class="sr-only">Username</label>
            <input type="text" id="username" name="username" class="form-control" placeholder="Username" required autofocus>
            <label for="password" class="sr-only">Password</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Log in</button>
        </form>

        @include('layouts.errors')

        <h5>Forgot your password?</h5>
        <p>Please contact the system admin to reset your account password.</p>
    </div> <!-- /container -->

@endsection