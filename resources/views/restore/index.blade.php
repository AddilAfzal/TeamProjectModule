@extends('layouts.master')

@section('content')
    <div class="container">
        <h3>System Restore</h3>
        @include('layouts.message')

        <table class="table">
            <thead>
            <th>Filename</th>
            <th>Date/Time</th>
            <th>Size</th>
            <th>Options</th>
            </thead>

            @foreach($backups as $backup)
                <tr>
                    <td>{{basename($backup)}}</td>
                    <td>{{\Carbon\Carbon::createFromTimestamp(Storage::lastModified($backup))}}</td>
                    <td>{{\App\File::bytesToHuman(Storage::size($backup))}}</td>
                    <td>
                        <form method="post" action="/restore/" style="display: inline;">
                            {{csrf_field()}}
                            <input type="hidden" value="{{basename($backup)}}" name="file"/>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-database"></i> Restore
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach

        </table>
    </div>

@endsection