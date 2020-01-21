<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModuleAssessmentResponseDetail extends Model
{
    
    use SoftDeletes;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'module_assessment_id',
                  'module_id',
                  'module_question_id',
                  'module_assessment_response_id',
                  'content',
                  'points',
                  'sequence'
              ];

    protected $dates = ['deleted_at'];

    public function moduleAssessment()
    {
        return $this->belongsTo('App\ModuleAssessment','module_assessment_id');
    }

    public function module()
    {
        return $this->belongsTo('App\Module','module_id');
    }

    public function moduleQuestion()
    {
        return $this->belongsTo('App\ModuleQuestion','module_question_id');
    }

    public function moduleAssessmentResponse()
    {
        return $this->belongsTo('App\ModuleAssessmentResponse','module_assessment_response_id');
    }
    
    public function scopeAssessmentResponseSheet($query)
    {
        $query->select(['module_assessment_response_details.id as id',
                        'module_assessment_response_details.module_assessment_response_id',
                        'module_assessment_response_details.module_assessment_id',
                        'module_assessment_response_details.module_id',
                        'module_assessment_response_details.module_question_id',
                        'module_questions.module_question_type_id', 'module_questions.title',
                        'module_questions.Points as question_points',
                        DB::raw("group_concat(module_question_choices.choice_text SEPARATOR '|') as question_choices"),
                        DB::raw("group_concat(module_question_choices.points SEPARATOR '|') as question_choices_points"),
                        DB::raw("group_concat(distinct module_assessment_response_details.content SEPARATOR '|') as response"),
                        DB::raw("group_concat(distinct module_assessment_response_details.points SEPARATOR '|') as points")])
              ->join('module_questions','module_questions.id','=','module_assessment_response_details.module_question_id')
              ->leftJoin('module_question_choices','module_question_choices.module_question_id','=','module_questions.id')
              ->leftJoin('module_assessment_responses','module_assessment_responses.id','=','module_assessment_response_details.module_assessment_response_id')
              ->groupBy(['module_assessment_response_details.id','module_assessment_response_details.module_question_id']);
    }

    public function scopeAssessmentResponseSheetByCourse($query)
    {
        $query->select(['module_assessment_response_details.id as id',
            'module_assessment_response_details.module_assessment_response_id',
            'module_assessment_response_details.module_assessment_id',
            'module_assessment_responses.module_id',
            'module_assessment_responses.course_id',
            'module_assessment_responses.deleted_at',
            'module_assessment_response_details.module_question_id',
            'module_questions.module_question_type_id', 'module_questions.title',
            'module_questions.Points as question_points',
            DB::raw("group_concat(module_question_choices.choice_text SEPARATOR '|') as question_choices"),
            DB::raw("group_concat(module_question_choices.points SEPARATOR '|') as question_choices_points"),
            DB::raw("group_concat(distinct module_assessment_response_details.content SEPARATOR '|') as response"),
            DB::raw("group_concat(distinct module_assessment_response_details.points SEPARATOR '|') as points")])
            ->join('module_questions','module_questions.id','=','module_assessment_response_details.module_question_id')
            ->leftJoin('module_question_choices','module_question_choices.module_question_id','=','module_questions.id')
            ->leftJoin('module_assessment_responses','module_assessment_responses.id','=','module_assessment_response_details.module_assessment_response_id')
            ->groupBy(['module_assessment_response_details.id',
                'module_assessment_response_details.module_question_id',
                'module_assessment_response_details.module_assessment_response_id',
                'module_assessment_responses.module_id',
                'module_assessment_responses.course_id'
            ]);
    }

}