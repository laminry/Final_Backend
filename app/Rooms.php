<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laraveldaily\Quickadmin\Observers\UserActionsObserver;

use Carbon\Carbon;



class Rooms extends Model {





    protected $table    = 'rooms';

    protected $fillable = [
          'roomtype',
          'image',
          'description',
          'checkin',
          'checkout',
          'price'
    ];


    public static function boot()
    {
        parent::boot();

        Rooms::observe(new UserActionsObserver);
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

    public function room(){
   return $this->belongsTo('App\Booking');
}

}
