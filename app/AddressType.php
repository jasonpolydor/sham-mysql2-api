<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class AddressType extends Model
{
    
    use SoftDeletes;



    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'description',
                  'is_system_predefined'
              ];

    public function addresses()
    {
        return $this->hasMany('App\Address','address_type_id','id');
    }


}