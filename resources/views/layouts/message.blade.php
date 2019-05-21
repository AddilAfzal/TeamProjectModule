@if(session('message'))
    <hr>
    @if(session('message')[0] == 'Failed')
        <div class="alert alert-danger">
    @else
        <div class="alert alert-success">
    @endif
        <h6>{{session('message')[0]}}</h6>
        <p>{{session('message')[1]}}</p>
    </div>
    @endif