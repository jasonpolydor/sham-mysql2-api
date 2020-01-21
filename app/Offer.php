<?php

namespace App;

use Plank\Mediable\Mediable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{
    use Mediable;
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