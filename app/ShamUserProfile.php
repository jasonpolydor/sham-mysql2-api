<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class ShamUserProfile extends Model
{
    use SoftDeletes;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'name',
                  'description'
              ];

    public $searchable = ['name', 'description'];

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
            'description'=>' Description'
        );
    }

    //Mutators and Accessors
    public function setActiveAttribute($value)
    {
        $this->attributes['Active'] = $value ?: null;
    }

    //Custom function to retrieve list for combo box
    public static function getComboList(){
        $arr = self::getList(['Name'], "" , "", "");
        $ret = array();
        $key = self::getKeyId();
        foreach ($arr as $element) {
            $ret[$element->$key]=$element->Name;
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shamPermissions()
    {
        return $this->belongsToMany('App\ShamPermission','sham_permission_sham_user_profile_system_sub_module')
            ->withPivot('system_sub_module_id');
    }

    public function systemSubModules()
    {
        return $this->belongsToMany('App\SystemSubModule','sham_permission_sham_user_profile_system_sub_module')
            ->withPivot('sham_permission_id')
            ->where('is_active','=',1);
    }

    public function systemModules()
    {
        return $this->hasManyThrough(
            'App\SystemSubModule',
            'sham_permission_sham_user_profile_system_sub_module',
            'sham_user_profile_id',
            'system_sub_module_id',
            'id',
            'systemmodule_id'
        );
    }
    public function listMatrix()
    {
        $temp = $this->
        join('sham_permission_sham_user_profile_system_sub_module', 'sham_user_profiles.id', '=', 'sham_permission_sham_user_profile_system_sub_module.sham_user_profile_id')
            ->leftJoin('system_sub_modules', 'sham_permission_sham_user_profile_system_sub_module.system_sub_module_id', '=', 'system_sub_modules.id')
            ->join('system_modules', 'system_sub_modules.system_module_id', '=', 'system_modules.id')
            ->select(['system_module_id','system_sub_module_id','sham_permission_id'])
            ->where([['sham_user_profile_id', '=', $this->id],['system_modules.deleted_at', '=', null]])
            ->get();

        $toReturn = array();

        foreach($temp as $item){
            if(!isset($toReturn[$item['system_module_id']])){
                $toReturn[$item['system_module_id']] = array();
            }
            if(!isset($toReturn[$item['system_module_id']][$item['system_sub_module_id']])){
                $toReturn[$item['system_module_id']][$item['system_sub_module_id']] = array();
            }
            $toReturn[$item['system_module_id']][$item['system_sub_module_id']] = 1;
        }
        
        return $toReturn;
    }
    //TODO: TO BE REVIEWED WHEN IMPLEMENTING SERVICE
    protected static $subModuleId = SystemSubModule::CONST_SYSTEM_CONFIGURATION;
}
?>
