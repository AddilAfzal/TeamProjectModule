@if (count($errors->all()) > 0)
    <br>
    <div class="alert alert-warning">
        <h6>Error</h6>
        @foreach($errors->all() as $error)
            <p>{{$error}}</p>
        @endforeach
    </div>
@endif