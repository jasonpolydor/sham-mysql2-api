<?php

namespace App;

class EmployeeHeadcountDeptView extends ViewModel
{

    protected $casts = [
        'Id'   => 'integer',
        'Department'   => 'string'
    ];

    protected $guarded = [
        'Id'   => 'integer',
    ];

    protected $fillable = [
        'Id',
        'Department'
    ];

    /**
     * Get an array of fields for the search filters in format key=>value
     * where key is the Field Name and Value is a field description
     * @return array
     */
    public static function getSearcheableFields()
    {
        return array();
    }

    /**
     * Get an array of fields for the listing table in format key=>value
     * where key is the Field Name and Value is a field description
     * @return array
     */
    public static function getListFields()
    {
        return array();
    }

    //Accessors and Mutators


    //TODO: TO BE REVIEWED WHEN IMPLEMENTING SERVICE
	protected static $subModuleId = SystemSubModule::CONST_DASHBOARD;
    protected static $api = "HeadCountByDepartmentViews";
    protected $table = "headcountbydepartment_view";
}
?>
