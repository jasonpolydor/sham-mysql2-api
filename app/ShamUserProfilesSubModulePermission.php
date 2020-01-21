<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;

class ShamUserProfilesSubModulePermission extends Model
{

    protected $casts = [
        'Id'   => 'integer',
        'ShamUserProfileId'=>'integer',
        'ShamPermissionId'=>'integer',
        'SystemSubModuleId'=>'integer',
    ];

    protected $guarded = [
        'Id'   => 'integer',
    ];

    protected $fillable = [
        'ShamUserProfileId',
        'ShamPermissionId',
        'SystemSubModuleId',
    ];


    /**
     * Get an array of fields for the search filters in format key=>value
     * where key is the Field Name and Value is a field description
     * @return array
     */
    public static function getSearcheableFields()
    {
        return array(
            'Name'=>'Name',
        );
    }

    /**
     * Get an array of fields for the listing table in format key=>value
     * where key is the Field Name and Value is a field description
     * @return array
     */
    public static function getListFields()
    {
        return array(
            'ShamUserProfileId'=>' Sham User Profile Id',
            'ShamPermissionId'=>' Sham Permission Id',
            'SystemSubModuleId'=>' System Sub Module Id',

        );
    }

    //Mutators and Accessors
    public function setShamUserProfileIdAttribute($value)
    {
    	$this->attributes['ShamUserProfileId'] = $value ?: null;
    }
    public function setShamPermissionIdAttribute($value)
    {
    	$this->attributes['ShamPermissionId'] = $value ?: null;
    }
    public function setSystemSubModuleIdAttribute($value)
    {
    	$this->attributes['SystemSubModuleId'] = $value ?: null;
    }

    /**
     * Get an array of fields allowed in the Model
     * @return array
     */
    public function getFillableFields()
    {
        return $this->fillable;
    }

    public function SystemModules() {
        return $this->belongsToMany('App\SystemModule')->select('id');
    }
    
    public function SystemSubModules() {
        return $this->belongsToMany('App\SystemSubModule')->select('id');
    }

    //TODO: TO BE REVIEWED WHEN IMPLEMENTING SERVICE
	protected static $subModuleId = SystemSubModule::CONST_SYSTEM_CONFIGURATION;
    protected static $api = "ShamUserProfilesSubModulePermissions";
    protected $table = 'shamuserprofilessubmodulepermissions';
}
?>
