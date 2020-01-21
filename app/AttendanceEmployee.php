<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use San4io\EloquentFilter\Filters\LikeFilter;
use Illuminate\Database\Eloquent\Builder;
use Jedrzej\Searchable\Constraint;
use San4io\EloquentFilter\Filters\WhereFilter;

class AttendanceEmployee extends Model
{
    use SoftDeletes;
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'employee_id',
                  'check_in',
                  'check_out',
                  'check_in_comments',
                  'check_out_comments'
              ];

    public $searchable = [
        'name',
        'check_in',
        'check_out'
    ];

    protected $filterable = [
        'name' => LikeFilter::class,
        'check_in' => LikeFilter::class,
        'check_out' => LikeFilter::class
    ];

    public function employees()
    {
        return $this->hasMany('App\Employee','id','employee_id');
    }

    protected function processNameFilter(Builder $builder, Constraint $constraint)
    {
        // this logic should happen for LIKE/EQUAL operators only
        if ($constraint->getOperator() === Constraint::OPERATOR_LIKE || $constraint->getOperator() === Constraint::OPERATOR_EQUAL) {

            $builder->with('employees')
                ->whereHas('employees',function ($q) use ($constraint){
                    $q->where('employees.first_name', $constraint->getOperator(), $constraint->getValue())
                        ->orWhere('employees.surname', $constraint->getOperator(), $constraint->getValue());
                });

            return true;
        }
        return false;
    }
}
