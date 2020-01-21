<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModuleAssessmentQuestion extends Model
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'module_assessment_questions';

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
                  'module_assessment_id',
                  'module_question_id',
                  'sequence'
              ];

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
    
    /**
     * Get the moduleAssessment for this model.
     */
    public function moduleAssessment()
    {
        return $this->belongsTo('App\ModuleAssessment','module_assessment_id');
    }

    /**
     * Get the moduleQuestion for this model.
     */
    public function moduleQuestion()
    {
        return $this->hasOne('App\ModuleQuestion','id','module_question_id');
    }

}
