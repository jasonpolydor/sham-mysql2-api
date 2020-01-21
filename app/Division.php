<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class Division extends Model
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

    public $searchable = ['Description'];

    public function employees()
    {
        return $this->hasMany('App\Employee')->select(['id','first_name','surname']);
    }


}