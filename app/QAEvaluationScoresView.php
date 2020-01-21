<?php

namespace App;

class QAEvaluationScoresView extends ViewModel
{

    /**
     * Create a new model instance.
     *
     */
    public function __construct() {}

    protected $casts = [
        'Id'   => 'integer',
        'EvaluationId'   => 'integer',
        'AssessmentId'   => 'integer',
        'AssessorEmployeeId'   => 'integer',
        'FeedbackDate'   => 'datetime',
        'Points'   => 'integer',
        'TotalThreshold'   => 'integer',
        'Percentage'   => 'integer',
    ];


    protected $guarded = [
        'Id'   => 'integer',
    ];

    protected $fillable = [
        'Id',
        'EvaluationId',
        'AssessmentId',
        'AssessorEmployeeId',
        'FeedbackDate',
        'Points',
        'TotalThreshold',
        'Percentage'
    ];

    //Accessors and Mutators

    //TODO: TO BE REVIEWED WHEN IMPLEMENTING SERVICE
	protected static $subModuleId = SystemSubModule::CONST_DASHBOARD;
    protected $table = "qaevaluationscoresview";

}
?>
