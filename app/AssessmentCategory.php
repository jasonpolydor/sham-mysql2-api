<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class AssessmentCategory extends Model
{
    
    use SoftDeletes;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'name',
                  'description',
                  'passmark_percentage',
                  'threshold'
              ];

    public $searchable = ['name','description'];

    public function assessmentCategoryCategoryQuestions()
    {
        return $this->belongsToMany(CategoryQuestion::class,'assessment_category_category_question','assessment_category_id','category_question_id')
            ->withPivot('is_active')->where('assessment_category_category_question.is_active',1);;
    }

    public function assessmentsAssessmentCategories()
    {
        return $this->hasMany('App\AssessmentsAssessmentCategory','assessmentcategory_id','id');
    }

    public function evaluationResults()
    {
        return $this->hasMany('App\EvaluationResult','assessmentcategory_id','id');
    }

    public function isAssessmentCategoryInUse()
    {
        $retvalue = false;
        $count = count($this->belongsToMany(Evaluation::class,'evaluation_results','assessment_category_id','evaluation_id')->get());
        if($count > 0)
        {
            $retvalue = true;
        }
        return $retvalue;
    }


}