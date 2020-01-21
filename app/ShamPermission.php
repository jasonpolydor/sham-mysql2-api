<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShamPermission extends Model
{

    protected $casts = [
        'id'   => 'integer',
        'name' => 'string',
        'description' => 'string',
        'is_active'=>'boolean',
    ];

    protected $guarded = [
        'id'   => 'integer',
    ];

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];


    /**
     * Get an array of fields for the search filters in format key=>value
     * where key is the Field Name and Value is a field description
     * @return array
     */
    public static function getSearcheableFields()
    {
        return array(
            'name'=>' Name',
            'description'=>' Description',
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
            'name'=>' Name',
            'description'=>' Description',

        );
    }

//Mutators and Accessors
    public function setActiveAttribute($value)
    {
    	$this->attributes['is_active'] = $value ?: null;
    }

    //Custom function to retrieve list for combo box
    public static function getComboList(){
        $arr = self::getList(['name'], "" , "", "");
        $ret = array();
        $key = self::getKeyId();
        foreach ($arr as $element) {
            $ret[$element->$key]=$element->name;
        }
        return $ret;
    }

	/**
     * @param $Id - Id of the record for which we need the description
     * @return string description of the field associated to the Id
     */
    public static function GetDescription($Id)
    {
        $item = static::find($Id);
        if ($item!=null) return $item->name;
        else return "";
    }

    /**
     * Get an array of fields allowed in the Model
     * @return array
     */
    public function getFillableFields()
    {
        return $this->fillable;
    }

    public function shamUserProfiles() {
        return $this->belongsToMany('App\ShamUserProfile', 'sham_permission_sham_user_profile_system_sub_module');
    }

    //TODO: TO BE REVIEWED WHEN IMPLEMENTING SERVICE
	protected static $subModuleId = SystemSubModule::CONST_SYSTEM_CONFIGURATION;
    protected static $api = "ShamPermissions";
    protected $table = 'sham_permissions';
}
?>
