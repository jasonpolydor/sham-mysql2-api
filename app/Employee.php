<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Plank\Mediable\Mediable;
use Jedrzej\Searchable\Constraint;
use App\Traits\MyAuditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use San4io\EloquentFilter\Filters\LikeFilter;
use San4io\EloquentFilter\Filters\WhereFilter;

class Employee extends Model implements AuditableContract
{
    use Mediable, MyAuditable, SoftDeletes;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'title_id', 'initials', 
                  'first_name', 'surname', 'known_as',
                  'full_name', 'birth_date', 'marital_status_id',
                  'id_number', 'passport_country_id', 'nationality',
                  'language_id', 'gender_id',
                  'ethnic_group_id', 'immigration_status_id',
                  'time_group_id', 'passport_no',
                  'spouse_full_name', 'employee_no',
                  'employee_code', 'tax_number',
                  'tax_status_id', 'date_joined',
                  'date_terminated', 'department_id',
                  'team_id', 'employee_status_id',
                  'physical_file_no', 'job_title_id',
                  'division_id', 'branch_id',
                  'picture', 'line_manager_id',
                  'leave_balance_at_start','probation_end_date'
              ];

    protected $dates = ['deleted_at'];

    public $searchable = ['title:description', 'name', 'jobtitle:description', 'department:description', 'employee_no','gender:description', 'employeestatus:description'];

    protected $auditInclude = ['title_id', 'initials', 
        'first_name', 'surname', 'known_as',
        'birth_date', 'marital_status_id',
        'id_number', 'passport_country_id',
        'nationality', 'language_id',
        'ethnic_group_id',
        'immigration_status_id', 'time_group_id',
        'passport_no', 'spouse_full_name',
        'employee_no', 'employee_code',
        'tax_status_id', 'tax_number', 
        'date_joined', 'date_terminated', 'probation_end_date',
        'employee_status_id', 'physical_file_no',
        'job_title_id', 'line_manager_id',
        'division_id', 'branch_id', 
        'department_id', 'team_id'
    ];

    protected $auditableEvents = [
        'created', 'updated',
        'deleted', 'restored'
    ];
    protected $auditRelatedProperties = ['mobilePhone', 'homePhone', 'workPhone'];

    protected $filterable = [
        'full_name' => LikeFilter::class,
        'is_manually_adjusted' => WhereFilter::class,
    ];


    public static function boot()
    {
        parent::boot();
    
        static::addGlobalScope('employeeFullName', function (Builder $builder) {
			if(is_null($builder->getQuery()->columns)){
				$builder->addSelect('*');
			}
            $builder->addSelect(DB::raw('CONCAT(first_name, " ", surname) AS full_name'));

            $builder->addSelect(DB::raw('CONCAT(first_name, " ", surname, " - ", employee_no) AS full_name_withemployeeno'));
        });
    }
	
    public function scopeEmployeesLite($query)
    {
        $this->withEmployeesLite($query);
    }

    public function scopeEmployeesList($query, $is_terminated, $search_term)
    {
        $query->leftJoin('departments', 'departments.id', '=', 'employees.department_id')
            ->leftJoin('job_titles', 'job_titles.id', '=', 'employees.job_title_id')
            ->leftJoin('employee_statuses','employee_statuses.id', '=', 'employees.employee_status_id')
            ->select('employees.id', 'employees.first_name', 'employees.surname',
                'employees.employee_no','employees.id_number','employees.probation_end_date',
                'job_titles.description as job_title',
                'departments.description as department',
                'employee_statuses.description as employee_status',
                'employees.date_terminated'
            )
            ->orderBy('employees.id');
        ;

        if (is_null($search_term)) {
            if ($is_terminated)
                $query->where('employees.date_terminated', '!=', null);
            else
                $query->where('employees.date_terminated', '=', null);
        }
    }

    public function scopeEmployeesEligibility($query, $startDate, $endDate){
        $query->leftJoin('eligibility_employee as eligibility', function($join) use ($startDate, $endDate){
                $join->on('employees.id','=','eligibility.employee_id')
                     ->where('eligibility.start_date','>=',$startDate)
                     ->where('eligibility.end_date','<=',$endDate);
              })
              ->select('employees.id','employees.job_title_id','employees.date_joined','employees.probation_end_date','eligibility.*')
              ->whereNull('employees.date_terminated')
        ;  
    }

    protected function withEmployeesLite($query)
    {
        $query->select(['job_title_id','first_name','surname','id','date_joined','probation_end_date'])
              ->whereNull('deleted_at');
    }

    protected function processNameFilter(Builder $builder, Constraint $constraint)
    {
        // this logic should happen for LIKE/EQUAL operators only
        if ($constraint->getOperator() === Constraint::OPERATOR_LIKE || $constraint->getOperator() === Constraint::OPERATOR_EQUAL) {
            $builder->where(function ($query) use ($constraint) {
                $query->where('first_name', $constraint->getOperator(), $constraint->getValue())
                    ->orWhere('known_as', $constraint->getOperator(), $constraint->getValue())
                    ->orWhere('surname', $constraint->getOperator(), $constraint->getValue());
            });

            return true;
        }

        // default logic should be executed otherwise
        return false;
    }

    public function disabilities()
    {
        return $this->belongsToMany(Disability::class);
    }

    public function title()
    {
        return $this->belongsTo('App\Title','title_id','id');
    }

    public function maritalstatus()
    {
        return $this->belongsTo('App\Maritalstatus','marital_status_id','id');
    }

    public function country()
    {
        return $this->belongsTo('App\Country','passport_country_id','id');
    }

    public function language()
    {
        return $this->belongsTo('App\Language','language_id','id');
    }

    public function gender()
    {
        return $this->belongsTo('App\Gender','gender_id','id');
    }

    public function ethnicGroup()
    {
        return $this->belongsTo('App\EthnicGroup','ethnic_group_id','id');
    }

    public function immigrationStatus()
    {
        return $this->belongsTo('App\ImmigrationStatus','immigration_status_id','Id');
    }

    public function timeGroup()
    {
        return $this->belongsTo('App\TimeGroup','time_group_id');
    }

    public function taxstatus()
    {
        return $this->belongsTo('App\Taxstatus','tax_status_id','id');
    }

    public function department()
    {
        return $this->belongsTo('App\Department');
    }

    public function team()
    {
        return $this->belongsTo('App\Team','team_id','id');
    }

    public function employeeStatus()
    {
        return $this->belongsTo('App\EmployeeStatus','employee_status_id','id');
    }

    public function jobTitle()
    {
        return $this->belongsTo('App\JobTitle');
    }

    public function division()
    {
        return $this->belongsTo('App\Division','division_id','id');
    }

    public function branch()
    {
        return $this->belongsTo('App\Branch','branch_id','id');
    }

    public function addresses()
    {
        return $this->hasMany('App\Address','employee_id','id')
        ->whereIn('address_type_id', [1,2]);
    }

    public function assetEmployee()
    {
        return $this->hasMany('App\AssetEmployee','employee_id','id');
    }

    public function courses()
    {
        return $this->belongsToMany('App\Course')->wherePivot('is_active', '=', 1);
    }

    public function commentdetail()
    {
        return $this->hasOne('App\Commentdetail','employee_id','id');
    }

    public function courseDiscussion()
    {
        return $this->hasOne('App\CourseDiscussion','employee_id','id');
    }

    public function courseEmployees()
    {
        return $this->hasMany('App\CourseEmployee','employee_id','id');
    }

    public function courseProgresses()
    {
        return $this->hasMany('App\CourseProgress','employee_id','id');
    }

    public function disciplinaryActions()
    {
        return $this->hasMany('App\DisciplinaryAction','employee_id','id');
    }

    public function emails()
    {
        return $this->hasMany('App\EmailAddress','employee_id','id')
                    ->whereIn('email_address_type_id', [1,2]);
    }

    public function employeeAttachment()
    {
        return $this->hasOne('App\EmployeeAttachment','employee_id','id');
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }

    public function eligibilities()
    {
        return $this->belongsToMany('App\AbsenceType', 'eligibility_employee')
            ->withPivot('start_date', 'end_date', 'total', 'taken', 'is_manually_adjusted','id','is_processed');
    }
    public function absences()
    {
        return $this->belongsToMany(AbsenceType::class, 'absence_type_employee')->withPivot('starts_at', 'ends_at', 'status', 'approved_by_employee_id');
    }

    public function evaluationassessors()
    {
        return $this->hasMany('App\Evaluationassessor','EmployeeId','id');
    }

    public function evaluationresult()
    {
        return $this->hasOne('App\Evaluationresult','AssessorEmployeeId','id');
    }

    public function evaluation()
    {
        return $this->hasOne('App\Evaluation','UserEmployeeId','id');
    }

    public function evaluations()
    {
        return $this->hasMany('App\Evaluation','CreatedByEmployeeId','id');
    }

    public function eventtaskinstances()
    {
        return $this->hasMany('App\Eventtaskinstance','TargetId','id');
    }

    public function historyDepartments()
    {
        return $this->hasMany('App\HistoryDepartment','employee_id','id');
    }

    public function historyDisciplinaryActions()
    {
        return $this->hasMany('App\HistoryDisciplinaryAction','employee_id','id');
    }

    public function historyJobTitles()
    {
        return $this->hasMany('App\HistoryJobTitle','employee_id','id');
    }

    public function historyTeams()
    {
        return $this->hasMany('App\HistoryTeam','employee_id','id');
    }

    public function historyJoinTermination()
    {
        return $this->hasMany('App\HistoryJoinTermination','employee_id','id');
    }

    public function historyQualification()
    {
        return $this->hasOne('App\HistoryQualification','employee_id','id');
    }

    public function historyRewards()
    {
        return $this->hasMany('App\HistoryReward','employee_id','id');
    }

    public function historyTraining()
    {
        return $this->hasOne('App\HistoryTraining','employee_id','id');
    }

    public function moduleassessmentresponses()
    {
        return $this->hasMany('App\Moduleassessmentresponse','EmployeeId','id');
    }

    public function moduleassessments()
    {
        return $this->hasMany('App\Moduleassessment','TrainerId','id');
    }

    public function qualifications()
    {
        return $this->hasMany('App\Qualification','employee_id','id');
    }

    public function recruitmentrequest()
    {
        return $this->hasOne('App\Recruitmentrequest','HiringManagerEmployeeId','id');
    }

    public function rewards()
    {
        return $this->hasMany('App\Reward','employee_id','id');
    }

    public function shamusers()
    {
        return $this->hasMany('App\Shamuser','EmployeeId','id');
    }

    public function phones()
    {
        return $this->hasMany('App\TelephoneNumber','employee_id','id')
                    ->whereIn('telephone_number_type_id', [1,2,3]);
    }

    public function timelines()
    {
        return $this->hasMany('App\Timeline','employee_id','id')->orderBy('event_date');
    }

    public function trainingSessions()
    {
        return $this->belongsToMany(TrainingSession::class);
    }

    #region ActivityLog compatible relations
    public function homePhone()
    {
        return $this->hasOne('App\TelephoneNumber','employee_id','id')
                    ->where('telephone_number_type_id', '=', 1);
    }

    public function mobilePhone()
    {
        return $this->hasOne('App\TelephoneNumber','employee_id','id')
                    ->where('telephone_number_type_id', '=', 2);
    }

    public function workPhone()
    {
        return $this->hasOne('App\TelephoneNumber','employee_id','id')
                    ->where('telephone_number_type_id', '=', 3);
    }

    public function privateEmail()
    {
        return $this->hasOne('App\EmailAddress','employee_id','id')
                    ->where('email_address_type_id', '=', 1);
    }

    public function workEmail()
    {
        return $this->hasOne('App\EmailAddress','employee_id','id')
                    ->where('email_address_type_id', '=', 2);
    }

    public function homeAddress()
    {
        return $this->hasOne('App\Address','employee_id','id')
                    ->where('address_type_id', '=', 1);
    }

    public function postalAddress()
    {
        return $this->hasOne('App\Address','employee_id','id')
                    ->where('address_type_id', '=', 2);
    }
    #endregion

    public function user()
    {
        return $this->hasOne('App\User','employee_id','id');
    }

    /**
     * {@inheritdoc}
     */
    public function transformAudit(array $data): array
    {
        if (Arr::has($data, 'new_values.gender_id')) {
            $data['old_values']['gender'] = optional(Gender::find($this->getOriginal('gender_id')))->description;
            $data['new_values']['gender'] = optional(Gender::find($this->getAttribute('gender_id')))->description;
        }
        if (Arr::has($data, 'new_values.title_id')) {
            $data['old_values']['title'] = optional(Title::find($this->getOriginal('title_id')))->description;
            $data['new_values']['title'] = optional(Title::find($this->getAttribute('title_id')))->description;
        }
        if (Arr::has($data, 'new_values.marital_status_id')) {
            $data['old_values']['marital_status'] = optional(MaritalStatus::find($this->getOriginal('marital_status_id')))->description;
            $data['new_values']['marital_status'] = optional(MaritalStatus::find($this->getAttribute('marital_status_id')))->description;
        }
        
        if (Arr::has($data, 'new_values.passport_country_id')) {
            $data['old_values']['passport_country'] = optional(Country::find($this->getOriginal('passport_country_id')))->description;
            $data['new_values']['passport_country'] = optional(Country::find($this->getAttribute('passport_country_id')))->description;
        }
        
        if (Arr::has($data, 'new_values.immigration_status_id')) {
            $data['old_values']['immigration_status'] = optional(ImmigrationStatus::find($this->getOriginal('immigration_status_id')))->description;
            $data['new_values']['immigration_status'] = optional(ImmigrationStatus::find($this->getAttribute('immigration_status_id')))->description;
        }
        if (Arr::has($data, 'new_values.ethnic_group_id')) {
            $data['old_values']['ethnic_group_id'] = optional(EthnicGroup::find($this->getOriginal('ethnic_group_id')))->description;
            $data['new_values']['ethnic_group_id'] = optional(EthnicGroup::find($this->getAttribute('ethnic_group_id')))->description;
        }

        if (Arr::has($data, 'new_values.division_id')) {
            $data['old_values']['division'] = optional(Division::find($this->getOriginal('division_id')))->description;
            $data['new_values']['division'] = optional(Division::find($this->getAttribute('division_id')))->description;
        }
        if (Arr::has($data, 'new_values.branch_id')) {
            $data['old_values']['branch'] = optional(Branch::find($this->getOriginal('branch_id')))->description;
            $data['new_values']['branch'] = optional(Branch::find($this->getAttribute('branch_id')))->description;
        }
        if (Arr::has($data, 'new_values.department_id')) {
            $data['old_values']['department'] = optional(Department::find($this->getOriginal('department_id')))->description;
            $data['new_values']['department'] = optional(Department::find($this->getAttribute('department_id')))->description;
        }
        if (Arr::has($data, 'new_values.team_id')) {
            $data['old_values']['team'] = optional(Team::find($this->getOriginal('team_id')))->description;
            $data['new_values']['team'] = optional(Team::find($this->getAttribute('team_id')))->description;
        }
        if (Arr::has($data, 'new_values.job_title_id')) {
            $data['old_values']['job_title'] = optional(JobTitle::find($this->getOriginal('job_title_id')))->description;
            $data['new_values']['job_title'] = optional(JobTitle::find($this->getAttribute('job_title_id')))->description;
        }
        if (Arr::has($data, 'new_values.line_manager_id')) {
            $data['old_values']['line_manager'] = optional(Employee::find($this->getOriginal('line_manager_id')))->full_name;
            $data['new_values']['line_manager'] = optional(Employee::find($this->getAttribute('line_manager_id')))->full_name;
        }
        if (Arr::has($data, 'new_values.employee_status_id')) {
            $data['old_values']['employee_status'] = optional(EmployeeStatus::find($this->getOriginal('employee_status_id')))->description;
            $data['new_values']['employee_status'] = optional(EmployeeStatus::find($this->getAttribute('employee_status_id')))->description;
        }

        if (Arr::has($data, 'new_values.tax_status_id')) {
            $data['old_values']['tax_status'] = optional(TaxStatus::find($this->getOriginal('tax_status_id')))->description;
            $data['new_values']['tax_status'] = optional(TaxStatus::find($this->getAttribute('tax_status_id')))->description;
        }

        return $data;
    }

}