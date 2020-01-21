<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class ModuleAssessmentResponse extends Model
{
    
    use SoftDeletes;



    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'module_id',
                  'employee_id',
                  'date_start',
                  'date_end',
                  'date_completed',
                  'is_reviewed',
                  'module_assessment_id',
                  'course_id',
              ];

    protected $dates = ['deleted_at'];

    public function module()
    {
        return $this->belongsTo('App\Module','module_id');
    }

    public function employee()
    {
        return $this->belongsTo('App\Employee','employee_id');
    }

    public function moduleAssessment()
    {
        return $this->belongsTo('App\ModuleAssessment','module_assessment_id');
    }

    public function course()
    {
        return $this->belongsTo('App\Course','course_id');
    }

    public function moduleAssessmentResponseDetails()
    {
        return $this->hasMany('App\ModuleAssessmentResponseDetail','module_assessment_response_id');
    }

}