<?php

namespace App;

class QAEvaluationsView extends ViewModel
{

    /**
     * Create a new model instance.
     *
     */
    public function __construct() {}

    protected $casts = [
        'Id'   => 'integer',
        'TotalPoints'   => 'integer',
        'TotalThreshold'   => 'integer',
        'description'   => 'string',
        'Feedbackdate'   => 'datetime',
    ];

    protected $guarded = [
        'id'   => 'integer',
    ];

    protected $fillable = [
        'Id',
        'TotalPoints',
        'TotalThreshold',
        'description',
        'Feedbackdate',
    ];

    //TODO: TO BE REVIEWED WHEN IMPLEMENTING SERVICE
	protected static $subModuleId = SystemSubModule::CONST_DASHBOARD;
    protected $table = "qaevaluationsview";

}
?>