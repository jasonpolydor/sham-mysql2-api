<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class SystemModule extends Model
{
    use SoftDeletes;

    const CONST_CENTRAL_HR = 1;
    const CONST_EMPLOYEE_PORTAL = 2;
    const CONST_QUALITY_ASSURANCE = 3;
    const CONST_RECRUITMENT = 4;
    const CONST_TRAINING = 5;
    const CONST_TIME_ATTENDANCE = 6;
    const CONST_SALARY_BENEFITS = 7;
    const CONST_PERFORMANCE = 8;
    const CONST_TALENT_SUCCESSION = 9;
    const CONST_PRODUCTIVITY_MANAGEMENT = 10;
    const CONST_DASHBOARD = 11;
    const CONST_CONFIGURATION_PARAMETERS = 12;
    const CONST_TODO_LIST = 13;
    const CONST_LEAVE = 14;

    protected $primaryKey = "id";

    protected $casts = [
        'id' => 'integer',
        'description' => 'string',
        'is_active' => 'boolean',
    ];

    protected $guarded = [
        'id' => 'integer',
    ];

    protected $fillable = [
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
            'Description' => ' Description',
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
            'description' => ' Description',

        );
    }

    //Mutators and Accessors
    public function setActiveAttribute($value)
    {
        $this->attributes['Active'] = $value ?: null;
    }

    //Custom function to retrieve list for combo box
    public static function getComboList()
    {
        $arr = self::getList(['Description'], "", "", "");
        $ret = array();
        $key = self::getKeyId();
        foreach ($arr as $element) {
            $ret[$element->$key] = $element->Description;
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
        if ($item != null) {
            return $item->Description;
        } else {
            return "";
        }

    }

    /**
     * Get an array of fields allowed in the Model
     * @return array
     */
    public function getFillableFields()
    {
        return $this->fillable;
    }

    public function subModules()
    {
        return $this->hasMany(SystemSubModule::class, 'system_module_id');
    }

    //TODO: TO BE REVIEWED WHEN IMPLEMENTING SERVICE
    protected static $subModuleId = SystemSubModule::CONST_SYSTEM_CONFIGURATION;


}
