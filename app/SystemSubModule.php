<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;

class SystemSubModule extends Model
{
    
	use SoftDeletes;

    const CONST_EMPLOYEE_DATABASE = 1;
    const CONST_WORKFLOWS = 2;
    const CONST_CUSTOM_REPORTS = 3;
    const CONST_NOTIFICATIONS = 4;
    const CONST_ANNOUNCEMENTS = 5;
    const CONST_ASSETS_MANAGEMENT = 6;
    const CONST_ORGANISATION_STRUCTURE = 7;
    const CONST_LIFECYCLE_MANAGEMENT = 8;
    const CONST_SUGGESTIONS = 9;
    const CONST_SURVEYS = 10;
    const CONST_COMPLIANCE_MANAGEMENT = 11;
    const CONST_TRAVEL_MANAGEMENT = 12;
    const CONST_TEMPORARY_JOBS = 13;
    const CONST_COMPANY_DOCUMENTS = 14;
    const CONST_CALENDAR_EVENTS = 15;
    const CONST_MY_PORTAL = 16;
    const CONST_MY_DETAILS = 17;
    const CONST_MY_TRAVEL_REQUESTS = 18;
    const CONST_MY_SUGGESTIONS = 19;
    const CONST_MY_COURSES = 20;
    const CONST_MY_SURVEYS = 21;
    const CONST_MY_DISCIPLINARY_RECORDS = 22;
    const CONST_VACANCIES = 23;
    const CONST_MY_ASSESSMENTS = 24;
    const CONST_MY_CLAIMS = 25;
    const CONST_MY_LEAVES = 26;
    const CONST_MY_TIMESHEET = 27;
    const CONST_MY_APPRAISAL = 28;
    const CONST_NEWSLETTER = 29;
    const CONST_ASSESSMENTS = 30;
    const CONST_ASSESSMENT_CATEGORIES = 31;
    const CONST_CATEGORY_QUESTIONS = 32;
    const CONST_EVALUATIONS = 33;
    const CONST_ASSESS = 34;
    const CONST_QA_REPORTS = 35;
    const CONST_RECRUITMENT_REQUESTS = 36;
    const CONST_VACANCIES_OFFERS = 37;
    const CONST_APPLICANT_TRACKING = 38;
    const CONST_ON_BOARDING = 39;
    const CONST_RECRUITMENT_REPORTS = 40;
    const CONST_COURSES = 41;
    const CONST_MODULES = 42;
    const CONST_MODULE_ASSESSMENT = 43;
    const CONST_TRAINING_VENUE_MANAGEMENT = 44;
    const CONST_TRAINING_SESSION_MANAGEMENT = 45;
    const CONST_TRAINING_REPORTS = 46;
    const CONST_POLICIES_RULES = 47;
    const CONST_VACATION_LEAVE_TRACKING = 48;
    const CONST_GLOBAL_ABSENCE_CALENDAR = 49;
    const CONST_ATTENDANCE_MANAGEMENT = 50;
    const CONST_ACCRUALS_BALANCES_ABSENCE_PLANS = 51;
    const CONST_TIME_SHEETS = 52;
    const CONST_TIME_ATTENDANCE_REPORTS = 53;
    const CONST_PAYROLL_MANAGEMENT = 54;
    const CONST_PERFORMANCE_APPRAISAL = 55;
    const CONST_ANALYSE_BUDGET = 56;
    const CONST_BENEFITS_MANAGEMENT = 57;
    const CONST_COMPENSATION_MANAGEMENT = 58;
    const CONST_360_DEGREES_FEEDBACK = 59;
    const CONST_QUESTIONS = 60;
    const CONST_PERFORMANCE_WORKFLOW = 61;
    const CONST_GOALS = 62;
    const CONST_PERFORMANCE_ANALYSIS = 63;
    const CONST_WARNINGS = 64;
    const CONST_IDENTIFY_TALENTS = 65;
    const CONST_CAREER_DEVELOPMENT_PLANNING = 66;
    const CONST_TALENT_POOLS = 67;
    const CONST_SUCCESSION_PLANING = 68;
    const CONST_KPI_IMPORTS = 69;
    const CONST_DASHBOARD = 70;
    const CONST_REPORTS = 71;
    const CONST_ADVANCE_METHODS = 72;
    const CONST_ANNOUNCEMENT_STATUS = 73;
    const CONST_ASSESSMENT_TYPE = 74;
    const CONST_ASSET_CONDITION = 75;
    const CONST_BANK_ACCOUNT_TYPE = 76;
    const CONST_BRANCH = 77;
    const CONST_CATEGORY_QUESTION_TYPE = 78;
    const CONST_COMPANY = 79;
    const CONST_COUNTRY = 80;
    const CONST_CURRENCY = 81;
    const CONST_DEPARTMENT = 82;
    const CONST_DIVISION = 83;
    const CONST_DOCUMENT_CATEGORY = 84;
    const CONST_DOCUMENT_TYPE = 85;
    const CONST_EMPLOYEE_STATUS = 86;
    const CONST_EMPLOYMENT_STATUS = 87;
    const CONST_ETHNIC_GROUP = 88;
    const CONST_GENDER = 89;
    const CONST_IMMIGRATION_STATUS = 90;
    const CONST_IMPORT = 91;
    const CONST_JOB_TITLE = 92;
    const CONST_LANGUAGE = 93;
    const CONST_LAW_CATEGORY = 94;
    const CONST_LEARNING_MATERIAL_TYPE = 95;
    const CONST_MARITAL_STATUS = 96;
    const CONST_NOTIFICATION_GROUPS = 97;
    const CONST_POLICY_CATEGORY = 98;
    const CONST_RECRUITMENT_REQUEST_REASONS = 99;
    const CONST_RECURRENCE = 100;
    const CONST_SKILLS = 101;
    const CONST_SYSTEM_CONFIGURATION = 102;
    const CONST_TAX_STATUS = 103;
    const CONST_TEAM = 104;
    const CONST_TIME_GROUP = 105;
    const CONST_TITLE = 106;
    const CONST_TRAINING_DELIVERY_METHOD = 107;
    const CONST_TRAVEL_EXPENSE_CLAIM_STATUSES = 108;
    const CONST_TRAVEL_REQUEST_STATUSES = 109;
    const CONST_TRIGGERS_EVENTS = 110;
    const CONST_VIOLATION = 111;
    const CONST_CALENDAR_EVENTS_DUPLICATE = 112;
    const CONST_EMPLOYEE_ATTACHMENT_TYPES = 113;
    const CONST_QA_INSTANCES= 114;
    const CONST_PRODUCT_CATEGORIES= 115;
    const CONST_PUBLIC_HOLIDAYS = 116;
    const CONST_LEAVE_TYPES = 117;
    const CONST_PRODUCTS = 118;
    const CONST_REPORT_TEMPLATES = 119;
    const CONST_TOPICS = 120;
    const CONST_TODOLIST_INSTANCES = 121;
    const CONST_MY_DOCUMENTS = 122;
    const CONST_MY_TODOLISTS = 123;
    const CONST_EVENTS = 124;
    const CONST_LINK_TYPES = 125;
    const CONST_TODO_ITEMS = 126;
    const CONST_TIMEPERIODS = 127;
    const CONST_DISCIPLINARYDECISIONS = 128;
    const CONST_DISABILITY = 129;
    const CONST_DISABILITY_CATEGORY = 130;
    const CONST_RECRUITMENT_CANDIDATES = 131;
    const CONST_RECRUITMENT_INTERVIEWS = 132;
    const CONST_RECRUITMENT_QUALIFICATIONS= 133;
    const CONST_ABSENCE_TYPES= 134;
    const CONST_ENTITLEMENTS= 135;
    const CONST_LEAVES= 136;
    const CONST_RECRUITMENT_CONTRACTS = 137;
    const CONST_RECRUITMENT_OFFERS = 138;
    const CONST_LOCATION = 139;


    protected $casts = [
        'id' => 'integer',
        'systemmodule_id'=>'integer',
		'description'=>'string',
    ];

    protected $guarded = [
        'id'   => 'integer',
    ];

    protected $fillable = [
        'description',
        'systemmodule_id',
        'active',
    ];


    /**
     * Get an array of fields for the search filters in format key=>value
     * where key is the Field Name and Value is a field description
     * @return array
     */
    public static function getSearcheableFields()
    {
        return array(
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
            'description'=>' Description',

        );
    }

    //Mutators and Accessors
    public function setSystemModuleIdAttribute($value)
    {
    	$this->attributes['SystemModuleId'] = $value ?: null;
    }
    public function setActiveAttribute($value)
    {
    	$this->attributes['Active'] = $value ?: null;
    }

    //Custom function to retrieve list for combo box
    public static function getComboList(){
        $arr = self::getList(['Description'], "" , "", "");
        $ret = array();
        $key = self::getKeyId();
        foreach ($arr as $element) {
            $ret[$element->$key]=$element->Description;
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
        if ($item!=null) return $item->Description;
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
	
	public function systemModule()
	{
		return $this->belongsTo(SystemModule::class, 'systemmodule_id');
	}
	
    public function shamPermissions() {
        return $this->belongsToMany(ShamPermission::class, 'sham_permission_sham_user_profile_system_sub_module', 'sham_permission_id');
	}
	
    //TODO: TO BE REVIEWED WHEN IMPLEMENTING SERVICE
	protected static $subModuleId = SystemSubModule::CONST_SYSTEM_CONFIGURATION;

}
?>
