<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
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

}