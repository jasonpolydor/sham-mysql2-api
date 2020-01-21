<?php

namespace App;


class HistoryJoinTermination extends Model
{
    


    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'employee_id',
                  'is_joined',
                  'date_occurred',
                  'updated_by_employee_id'
              ];

    public function employee()
    {
        return $this->belongsTo('App\Employee','employee_id');
    }



}