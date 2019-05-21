<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class RestoreController extends Controller
{
    public function index()
    {
        $this->checkDisable();
        $backups = Storage::files('http---localhost');

        $backups = array_reverse($backups);
        return view('restore.index')->with('title', 'Restores System')->with('backups', $backups);
    }

    public function performRestore(Request $request)
    {
        $this->checkDisable();

        $fullfilename = storage_path() . "/app/http---localhost/" . $request->file;

        if (File::exists($fullfilename)) {

            $zipper = new \Chumper\Zipper\Zipper;

            $zipper->zip($fullfilename)->extractTo(storage_path() . "/app/http---localhost/tmp/");

            $sql_file = File::glob(storage_path() . "/app/http---localhost/tmp/*.sql");
            DB::unprepared(file_get_contents($sql_file[0]));
            Storage::deleteDirectory('/app/http---localhost/tmp/"');

            return redirect('/restore/')
                ->with('message', ['Database Restored', 'Database has been resorted successfully.']);
        } else {
            return redirect('/restore/')
                ->with('message', ['Failed', 'File does not exist.' . $fullfilename]);
        }
    }

    public function checkDisable()
    {
        if(Config::get('app.enable_restore') != 1) {
            dd('Restore functionality is disabled by default for security reasons, please enable it in config/app.php . Set enable_restore to 1.');
        }
    }


}
