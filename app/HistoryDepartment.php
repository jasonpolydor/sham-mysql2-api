<?php

namespace App;

class HistoryDepartment extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'history_departments';

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
                'department_id',
                'date_occurred',
              ];

    public function employee()
    {
        return $this->belongsTo('App\Employee','employee_id');
    }

    public function department()
    {
        return $this->belongsTo('App\Department','department_id');
    }
}
