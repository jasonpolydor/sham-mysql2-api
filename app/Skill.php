<?php

namespace App;

use App\Traits\UsesPredefinedValues;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skill extends Model
{
    
    use SoftDeletes, UsesPredefinedValues;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'description',
                  'Level',
                  'is_system_predefined'
              ];

    public $searchable = ['description'];

    public function employees()
    {
        return $this->belongsToMany('App\Employee');
    }


    public function candidates()
    {
        return $this->belongsToMany('App\Candidate');
    }

}