<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use San4io\EloquentFilter\Filters\LikeFilter;
use San4io\EloquentFilter\Filters\WhereFilter;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

class Course extends Model
{

    use SoftDeletes/*, BlameableTrait*/;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'is_public',
        'overview',
        'objectives',
        'passmark_percentage',
        'created_by',
        'updated_by'
    ];

    public $searchable = ['description', 'overview', 'objectives', 'passmark_percentage', 'is_public'];

    protected $filterable = [
        'description' => LikeFilter::class,
        'overview' => LikeFilter::class,
        'objectives' => LikeFilter::class,
        'passmark_percentage' => WhereFilter::class,
        'is_public' => WhereFilter::class,
    ];
    
    protected static $logAttributes = ['description', 'overview', 'objectives', 'passmark_percentage', 'is_public'];
    protected static $logOnlyDirty = true;

    /**
     * You can override the default configuration
     * by defining this static property in your Model
     */
    protected static $blameable = [
        'guard' => 'sham',
        'user' => \App\User::class,
        'createdBy' => 'created_by',
        'updatedBy' => null
    ];

    public function modules()
    {
        return $this->belongsToMany(Module::class);
    }

    public function employees()
    {
        return $this->belongsToMany('App\Employee')
                ->withPivot(['courseparticipantstatus_id'])
                ->select(['employee_id','courseparticipantstatus_id','first_name', 'surname'])
                ->wherePivot('is_active', '=', 1);
    }

    public function employeeProgress()
    {
        return $this->belongsToMany('App\Employee', 'course_progress')
                    ->select(['employee_id','module_id','topic_id','is_completed','completed_at']);
    }

    public function courseEmployee()
    {
        return $this->belongsToMany('App\Employee', 'course_employee')
            ->select(['course_id','employee_id','courseparticipantstatus_id']);
    }

    public function trainingSessions()
    {
        return $this->hasMany(CourseTrainingSession::class);
    }

}
