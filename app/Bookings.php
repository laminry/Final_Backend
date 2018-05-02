<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laraveldaily\Quickadmin\Observers\UserActionsObserver;

use Carbon\Carbon;



class Bookings extends Model {





    protected $table    = 'bookings';

    protected $fillable = [
          'name',
          'email',
          'passid',
          'rooms_id',
          'checkin',
          'checkout',
          'noadults',
          'nochildren',
          'additional'
    ];


    public static function boot()
    {
        parent::boot();

        Bookings::observe(new UserActionsObserver);
    }






    /**
     * Set attribute to date format
     * @param $input
     */
    public function setCheckinAttribute($input)
    {
        if($input != '') {
            $this->attributes['checkin'] = Carbon::createFromFormat(config('quickadmin.date_format'), $input)->format('Y-m-d');
        }else{
            $this->attributes['checkin'] = '';
        }
    }

    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    public function getCheckinAttribute($input)
    {
        if($input != '0000-00-00') {
            return Carbon::createFromFormat('Y-m-d', $input)->format(config('quickadmin.date_format'));
        }else{
            return '';
        }
    }

/**
     * Set attribute to date format
     * @param $input
     */
    public function setCheckoutAttribute($input)
    {
        if($input != '') {
            $this->attributes['checkout'] = Carbon::createFromFormat(config('quickadmin.date_format'), $input)->format('Y-m-d');
        }else{
            $this->attributes['checkout'] = '';
        }
    }

    /**
     * Get attribute from date format
     * @param $input
     *
     * @return string
     */
    public function getCheckoutAttribute($input)
    {
        if($input != '0000-00-00') {
            return Carbon::createFromFormat('Y-m-d', $input)->format(config('quickadmin.date_format'));
        }else{
            return '';
        }
    }

    public function rooms()
{
    return $this->hasOne('App\Rooms', 'id', 'rooms_id');
}
}
