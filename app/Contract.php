<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    
    use SoftDeletes;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'description',
                  'content'
              ];


}