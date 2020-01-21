<?php

namespace App;

class HistoryJobTitle extends Model
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'history_job_titles';

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
        'job_title_id',
        'date_occurred',
    ];

    public function employee()
    {
        return $this->belongsTo('App\Employee','employee_id');
    }

    public function jobTitle()
    {
        return $this->belongsTo('App\JobTitle','job_title_id');
    }

}
