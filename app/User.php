<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password', 'username', 'role'
    ];

    public static $valid_roles = ['manager', 'admin', 'advisor'];

    public $timestamps = true;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function isValidRole($role)
    {
        return (in_array($role,self::$valid_roles));
    }

    public function sales() {
        return $this->hasMany('\App\Sale');
    }

    public function blanks() {
        return $this->hasMany('\App\Blank');
    }

    /*
     * Returns blanks that are assigned to the user and that have not been sold.
     */
    public function getBlanks() {
        $blanks = $this->blanks->where('is_sold', '0');
        return $blanks;
    }

    /*
     * Returns interline blanks that are assigned to the user and that have not been sold.
     */
    public function getInterlineBlanks() {
        $blanks = DB::table('blanks')
            ->join('blank_types', 'blank_types.id', '=', 'blanks.blank_type_id')
            ->where('blank_types.scope', 'INTERLINE')
            ->where('blanks.is_sold', '0')
            ->where('blanks.user_id', $this->id)
            ->get();

        return $blanks;
    }

    /*
     * Returns interline blanks that are assigned to the user and that have not been sold.
     */
    public function getDomesticBlanks() {
        $blanks = DB::table('blanks')
            ->join('blank_types', 'blank_types.id', '=', 'blanks.blank_type_id')
            ->where('blank_types.scope', 'DOMESTIC')
            ->where('blanks.is_sold', '0')
            ->where('blanks.user_id', $this->id)
            ->get();

        return $blanks;
    }

    public function getSoldBlanks() {
        $blanks = $this->blanks->where('is_sold', '0');
        return $blanks;
    }

    public function suspend() {
        $this->isSuspended = true;
        $this->save();
    }

    public function activate() {
        $this->isSuspended = false;
        $this->save();
    }


}
