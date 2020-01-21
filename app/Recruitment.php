<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Plank\Mediable\Mediable;
use San4io\EloquentFilter\Filters\LikeFilter;
use San4io\EloquentFilter\Filters\WhereFilter;

class Recruitment extends Model
{
    use Mediable;
    use SoftDeletes;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'recruitments';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'department_id',
        'employee_status_id',
        'qualification_id',
        'employee_id',
        'job_title_id',
        'field_of_study',
        'description',
        'year_experience',
        'start_date',
        'end_date',
        'probation_period',
        'quantity',
        'min_salary',
        'max_salary',
        'recruitment_type_id',
        'is_approved',
        'is_completed'
    ];

    protected $searchable = [
        'jobtitle:description',
        'recruitment_type_id',
        'qualification_recruitment:description',
        'year_experience',
        'field_of_study',
        'start_date',
        'is_approved',
        'is_completed'
    ];

    protected $filterable = [
        'recruitment_type_id' => LikeFilter::class,
        'qualification_recruitment:description' => LikeFilter::class,
        'year_experience' => LikeFilter::class,
        'field_of_study' => LikeFilter::class,
        'start_date' => LikeFilter::class,
        'is_approved' => WhereFilter::class,
        'is_completed' => WhereFilter::class,
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
               'deleted_at'
           ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    public function qualification()
    {
        return $this->belongsTo('App\QualificationRecruitment','qualification_id','id');
    }

    public function department()
    {
        return $this->belongsTo('App\Department','department_id','id');
    }

    public function jobTitle()
    {
        return $this->belongsTo('App\JobTitle','job_title_id');
    }

    public function employeeStatus()
    {
        return $this->belongsTo('App\EmployeeStatus','employee_status_id','id');
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }

    public function interviewTypes()
    {
        return $this->belongsToMany(Interview::class);
    }

    public function interviews()
    {
        return $this->belongsToMany(Interview::class, 'candidate_interview_recruitment','recruitment_id','interview_id')->withPivot('id', 'candidate_id', 'reasons','schedule_at','results','location','status');
    }

    public function qualification_recruitment()
    {
        return $this->belongsTo('App\QualificationRecruitment','qualification_id');
    }

    public function contracts()
    {
        return $this->belongsToMany(Contract::class,'contract_recruitment')->withPivot(['id','signed_on','comments','master_copy']);
    }

    public function offers()
    {
        return $this->belongsToMany(Offer::class,'offer_recruitment')->withPivot(['id','signed_on','starting_on','comments','master_copy']);
    }

    //Exclude GLOBALSCOPE 'candidateName' in candidate model not working in laravel 5.6+
    public function candidates()
    {
        return $this->belongsToMany(Candidate::class)
            ->withPivot('status')
            ->withoutGlobalScopes();
    }

    public function status()
    {
        return $this->belongsToMany(Recruitment::class, 'recruitment_status')->withPivot(['id','status']);
    }

    public function trackCandidateStatus()
    {
        return $this->belongsToMany(Candidate::class, 'recruitment_status')->withPivot(['id','status','comment'])->orderByRaw('ABS(pivot_status)','asc');;
    }
}
