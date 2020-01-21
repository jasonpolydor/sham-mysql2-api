<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    
    use SoftDeletes;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'description',
                  'is_preferred'
              ];

    public $searchable = ['description'];

    public function addresses()
    {
        return $this->hasMany('App\Address','country_id','id');
    }

    public function employees()
    {
        return $this->hasMany('App\Employee','passport_country_id','id');
    }

    public function laws()
    {
        return $this->hasMany('App\Law','country_id','id');
    }

    public function travelexpenseclaims()
    {
        return $this->hasMany('App\Travelexpenseclaim','CountryId','Id');
    }


}