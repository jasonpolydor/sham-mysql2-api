<?php

namespace App;

use App\Traits\UsesPredefinedValues;
use Illuminate\Database\Eloquent\SoftDeletes;

class Disability extends Model
{
    
    use SoftDeletes/*, UsesPredefinedValues*/;

    protected $table = 'disabilities';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'description',
                  'disability_category_id',
                  'is_system_predefined'
              ];

    public $searchable = ['description'];

    public function disabilityCategory()
    {
        return $this->belongsTo('App\DisabilityCategory');
    }

    public function employees()
    {
        return $this->belongsToMany('App\Employee');
    }

    public function candidates()
    {
        return $this->belongsToMany('App\Candidate');
    }
}