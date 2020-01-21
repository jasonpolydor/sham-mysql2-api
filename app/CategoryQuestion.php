<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryQuestion extends Model
{
    
    use SoftDeletes;



    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'title',
                  'category_question_type_id',
                  'description',
                  'points',
                  'is_zeromark'
              ];

    public $searchable = ['title','description'];

    public function categoryQuestionType()
    {
        return $this->belongsTo('App\CategoryQuestionType','category_question_type_id','id');
    }

    public function assessmentCategoryCategoryQuestions()
    {
        return $this->hasMany('App\AssessmentCategoryCategoryQuestion','categoryquestion_id','id');
    }

    public function categoryQuestionChoices()
    {
        return $this->hasMany('App\CategoryQuestionChoice','category_question_id','id');
    }

    public function evaluationResults()
    {
        return $this->hasMany('App\EvaluationResult','categoryquestion_id','id');
    }

    public function isCategoryQuestionInUse()
    {
        $retvalue = false;
        $count = count($this->belongsToMany(Evaluation::class,'evaluation_results','category_question_id','evaluation_id')->get());
        if($count > 0)
        {
            $retvalue = true;
        }
        return $retvalue;
    }
}