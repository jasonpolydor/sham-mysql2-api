<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class Timeline extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'timelines';

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
        'employee_id',
        'timeline_event_type_id',
        'event_id',
        'event_date',
    ];



    public function employee()
    {
        return $this->belongsTo('App\Employee','employee_id');
    }

    public function timelineEventType()
    {
        return $this->belongsTo('App\TimelineEventType','timeline_event_type_id');
    }

}
