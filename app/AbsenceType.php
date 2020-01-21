<?php

namespace App;

use App\Traits\MyAuditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use San4io\EloquentFilter\Filters\LikeFilter;
use San4io\EloquentFilter\Filters\WhereFilter;

class AbsenceType extends Model implements AuditableContract
{
    use SoftDeletes, MyAuditable;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'accrue_period',
                  'amount_earns',
                  'description',
                  'duration_unit',
                  'colour_id',
                  'eligibility_ends',
                  'eligibility_begins',
                  'non_working_days'
              ];

    protected $cascadeDeletes = ['eligibilityEmployees', 'jobTitles', 'absenceTypeEmployees'];

    public $searchable = [ 'accrue_period',
                            'amount_earns',
                            'description',
                            'duration_unit',
                            'eligibility_ends',
                            'eligibility_begins'
    ];

    protected $filterable = [
                'description' => LikeFilter::class,
                'eligibility_begins' => LikeFilter::class,
                'eligibility_ends' => LikeFilter::class,
                'duration_unit' => WhereFilter::class,
            ];

    protected $auditInclude = [
        'accrue_period',
        'amount_earns',
        'description',
        'duration_unit',
        'eligibility_ends',
        'eligibility_begins',
        'non_working_days'
    ];

    protected $auditableEvents = [
        'created', 'updated',
        'deleted', 'restored'
    ];

    public function eligibilityEmployees()
    {
        return $this->belongsToMany('App\Employee','eligibility_employee')->withPivot('id','start_date','end_date','total','taken','is_manually_adjusted');
    }

    public function jobTitles()
    {
        return $this->belongsToMany('App\JobTitle','absence_type_job_title');
    }

    public function absenceTypeEmployees()
    {
        return $this->belongsToMany('App\Employee','absence_type_employee');
    }

    public function colour()
    {
        return $this->belongsTo('App\Colour');
    }


}