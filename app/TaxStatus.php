<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class TaxStatus extends Model
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

    public $searchable = ['description'];

    public function employees()
    {
        return $this->hasMany('App\Employee');
    }


}