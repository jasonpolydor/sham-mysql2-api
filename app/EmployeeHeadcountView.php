<?php

namespace App;

class EmployeeHeadcountView extends ViewModel
{

    /**
     * Create a new model instance.
     *
     */
    public function __construct() {}

    protected $casts = [
        'Id'   => 'integer',
        'Sex'   => 'string',
        'Ethnicity'   => 'string',
        'TerminationDate'   => 'datetime',
        'JoinedDate'   => 'datetime',
    ];

    protected $guarded = [
        'Id'   => 'integer',
    ];

    protected $fillable = [
        'Id',
        'Sex',
        'Ethnicity',
        'TerminationDate',
        'JoinedDate',
        'Siz'
    ];

    //TODO: TO BE REVIEWED WHEN IMPLEMENTING SERVICE
	protected static $subModuleId = SystemSubModule::CONST_DASHBOARD;
    protected $table = "headcountbygender_view";

}
?>