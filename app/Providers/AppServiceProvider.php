<?php

namespace App\Providers;

use App\BlankType;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;




class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Validator::extend('blanktype_subtype', function ($attribute, $value, $parameters, $validator) {
            return BlankType::isValidSubType($value);
        });
        Validator::extend('blanktype_scope', function ($attribute, $value, $parameters, $validator) {
            return BlankType::isValidScope($value);
        });
        Validator::extend('commission_rate', function ($attribute, $value, $parameters, $validator) {
            return $value >= 0 && $value <= 1;
        });
        Validator::extend('user_role', function ($attribute, $value, $parameters, $validator) {
            return (\App\User::isValidRole($value));
        });
        Validator::extend('not_exists', function($attribute, $value, $parameters)
        {
            return DB::table($parameters[0])
                    ->where($parameters[1], '=', $value)
                    ->count()<1;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
