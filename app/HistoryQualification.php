<?php

namespace App;

class HistoryQualification extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'history_qualifications';

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
        'qualification_id',
        'date_occurred',
    ];

    public function employee()
    {
        return $this->belongsTo('App\Employee','employee_id');
    }

    public function qualification()
    {
        return $this->belongsTo('App\Qualification','qualification_id');
    }
    
}
