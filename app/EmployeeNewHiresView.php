<?php

namespace App;

class EmployeeNewHiresView extends ViewModel
{

    /**
     * Create a new model instance.
     *
     */
    public function __construct() {}

    protected $casts = [
        'Year'   => 'integer',
        'Count'   => 'integer',
        'Type'   => 'integer',
    ];

    protected $guarded = [
        'id'   => 'integer',
    ];

    protected $fillable = [
        'Name',
        'Year',
        'Count',
        'Type'
    ];

    //TODO: TO BE REVIEWED WHEN IMPLEMENTING SERVICE
	protected static $subModuleId = SystemSubModule::CONST_DASHBOARD;
    protected $table = "newhires_view";

}
?>