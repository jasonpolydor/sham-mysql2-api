<?php

namespace App;

class TrainingSessionParticipant extends Model
{

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'training_session_id',
                  'employee_id'
              ];

    public function courseTrainingSession()
    {
        return $this->belongsTo('App\CourseTrainingSession','training_session_id','id');
    }

    public function employee()
    {
        return $this->belongsTo('App\Employee','employee_id','id');
    }


}