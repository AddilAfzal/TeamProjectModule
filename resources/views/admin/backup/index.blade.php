@extends('layouts.master')

@section('content')
    <div class="container">

        <ol class="breadcrumb">
            <li><a href="/admin">Home</a></li>
            <li class="active">Backups</li>
        </ol>

        <h3>Backups</h3>
        @include('layouts.message')

        <form method="post" action="/admin/backups/" style="display: inline;">
            {{csrf_field()}}
            <input type="hidden" name="backup" value="confirm">
            <button class="btn btn-info" type="submit" href="/admin/backups/generate"><i class="fa fa-compress"
                                                                                         aria-hidden="true"></i>
                Generate
            </button>
        </form>
        <p>Pressing generate will back up the database and compress it into a zip file.</p>


        {{--<a class="btn btn-info" type="button" href="/admin/backups/restore"><i class="fa fa-repeat"--}}
                                                                               {{--aria-hidden="true"></i> Restore</a>--}}

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
                        <form method="post" action="/admin/backups/download/" style="display: inline;">
                            {{csrf_field()}}
                            <input type="hidden" value="{{basename($backup)}}" name="file" />
                            <button type="submit" class="btn btn-primary"><i class="fa fa-download"></i> Download</button>
                        </form>
                        <form method="post" action="/admin/backups/delete/" style="display: inline;">
                            {{csrf_field()}}
                            <input type="hidden" value="{{basename($backup)}}" name="file" />
                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach

        </table>
    </div>
@endsection