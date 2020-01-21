<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryQuestionChoice extends Model
{
    
    use SoftDeletes;



    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'category_question_id',
                  'choice_text',
                  'points'
              ];

    public function categoryQuestion()
    {
        return $this->belongsTo('App\CategoryQuestion','category_question_id','id');
    }


}