<?php

namespace App;

class AssetDataView extends ViewModel
{

    /**
     * Create a new model instance.
     *
     */
    public function __construct() {}

    protected $casts = [
        'name'   => 'string',
        'total'   => 'integer'
    ];

    protected $guarded = [
        'Id'   => 'integer',
    ];

    protected $fillable = [
        'name',
        'total'
    ];

    //TODO: TO BE REVIEWED WHEN IMPLEMENTING SERVICE
	protected static $subModuleId = SystemSubModule::CONST_DASHBOARD;
    protected $table = "assetdata_view";

}
?>