<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class TimelineEventType extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'timeline_event_types';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'name',
                  'description'
              ];


    public function timelines()
    {
        return $this->hasMany('App\Timeline','timeline_event_type_id','id');
    }
}
