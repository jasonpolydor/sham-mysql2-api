<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class TimePeriod extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'time_periods';

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
                  'description',
                  'start_time',
                  'end_time',
                  'time_period_type'
              ];

    public $searchable = ['description'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    public function timeGroups()
    {
        return $this->belongsToMany('App\TimeGroup','day_time_group_time_period');
    }

}
