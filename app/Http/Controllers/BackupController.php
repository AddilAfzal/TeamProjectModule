<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    public function index() {
        $backups = Storage::files('http---localhost');
        $backups = array_reverse($backups);
        return view(auth()->user()->role . ".backup.index")->with('title', 'Backups')->with('backups', $backups);
    }

    public function generateBackup(Request $request) {

        $this->validate($request,
            [
               'backup' => 'required|string'
            ]);

        Artisan::queue('backup:run', ['--only-db' => 1]);
        Artisan::queue('backup:clean', []);
        return redirect(auth()->user()->role . '/backups/')->with('message', ['Backup Initiated', "Please wait up to 5 minutes for the backup process to complete."]);
    }

    public function delete(Request $request)
    {
        Storage::delete('http---localhost/' . $request->file);
        return redirect(auth()->user()->role . '/backups/')->with('message', ['Backup Deleted', "Your selected back up has been deleted successfully."]);
    }

    public function download(Request $request)
    {
        return response()->download(storage_path() . "/app/http---localhost/" . $request->file);
    }




}