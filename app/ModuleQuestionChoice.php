<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class ModuleQuestionChoice extends Model
{
    
    use SoftDeletes;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'module_question_id',
                  'choice_text',
                  'correct_answer',
                  'points'
              ];

    public function moduleQuestion()
    {
        return $this->belongsTo('App\ModuleQuestion','module_question_id');
    }


}