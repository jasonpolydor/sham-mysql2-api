<?php

namespace App;


use App\Traits\UsesPredefinedValues;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeStatus extends Model
{

    use SoftDeletes, UsesPredefinedValues;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'description',
                  'is_system_predefined'
              ];

    public $searchable = ['description'];

    public function employees()
    {
        return $this->hasMany('App\Employee','employee_status_id','id');
    }

    public function temporaryjob()
    {
        return $this->hasOne('App\Temporaryjob','EmployeeStatusId','id');
    }


}