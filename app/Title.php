<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UsesPredefinedValues;

class Title extends Model
{
    
    use SoftDeletes, UsesPredefinedValues;

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

}