<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class TimeGroup extends Model
{
    
    use SoftDeletes;



    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'name',
                  'start',
                  'end'
              ];

    public $searchable = ['name'];

    protected $table = 'time_groups';

    public function timePeriods()
    {
        return $this->belongsToMany('App\TimePeriod','day_time_group_time_period')->withPivot('day_id')->orderBy('day_id');
    }

    public function days()
    {
        return $this->belongsToMany('App\Day','day_time_group_time_period')->withPivot('time_period_id');
    }
}