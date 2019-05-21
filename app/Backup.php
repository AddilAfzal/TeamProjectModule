<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Backup extends Model
{
    protected $fillable = ['filename', 'location', 'time'];
    public $timestamps = true;

    public static function generate()
    {
        $stringDate = Carbon::now()->toDateString();
        $stringTime = Carbon::now()->toTimeString();
        $filename = 'ats_backup_' . $stringDate.  '-' . $stringTime. '.sql';
        $location = '/home/team/' . $filename;

        exec('mysqldump --user=' . config('database.connections.mysql.username')
            . ' --password=' . config('database.connections.mysql.password')
            . '  --host=' . config('database.connections.mysql.host')
            . ' ' . config('database.connections.mysql.database')
            .  '  > ' . $location);

        Backup::create(
            [
            'filename' => "{$filename}",
            'location' => $location
            ]
        );
    }
}
