<?php

namespace App;

use San4io\EloquentFilter\Filters\LikeFilter;

use Illuminate\Database\Eloquent\SoftDeletes;
use Plank\Mediable\Mediable;
use Illuminate\Database\Eloquent\Builder;
use Jedrzej\Searchable\Constraint;
use Illuminate\Support\Facades\DB;

class AssetEmployee extends Model
{
    protected $table = "asset_employee";

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'asset_id',
                  'employee_id',
                  'date_out',
                  'date_in',
                  'comment'
              ];

    public $searchable = [
            'asset:name', 
            'asset:tag', 
            'asset:serial_no', 
            'name', 'date_out', 'date_in'
    ];
    
    /*
    protected $filterable = [
        'asset:name' => LikeFilter::class,
        'asset:tag' => LikeFilter::class,
        'asset:serial_no' => LikeFilter::class,
        'employee:full_name' => LikeFilter::class,
        'date_out' => LikeFilter::class,
        'date_in' => LikeFilter::class
    ];
    */

    public function asset()
    {
        return $this->belongsTo('App\Asset','asset_id','id');
    }

    public function employee()
    {
        return $this->belongsTo('App\Employee','employee_id','id')
                    ->select(['id']);
    }

    public function employeeInfos()
    {
        return $this->belongsTo('App\Employee','employee_id','id');
    }

    protected function processNameFilter(Builder $builder, Constraint $constraint)
    {
        // this logic should happen for LIKE/EQUAL operators only
        if ($constraint->getOperator() === Constraint::OPERATOR_LIKE || $constraint->getOperator() === Constraint::OPERATOR_EQUAL) {

            $builder->with('employee')
                ->whereHas('employee',function ($q) use ($constraint){
                    $q->where('employees.first_name', $constraint->getOperator(), $constraint->getValue())
                        ->orWhere('employees.surname', $constraint->getOperator(), $constraint->getValue());
                });

            return true;
        }
        return false;
    }


}
