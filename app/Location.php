<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
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

    public function candidates()
    {
        return $this->hasMany('App\Candidates', 'location_id', 'id');
    }
}
