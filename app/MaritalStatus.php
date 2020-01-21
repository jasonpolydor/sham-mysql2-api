<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UsesPredefinedValues;

class MaritalStatus extends Model
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

    protected $table = 'maritalstatuses';
}