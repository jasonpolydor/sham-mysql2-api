<?php

namespace App;

use App\Traits\UsesPredefinedValues;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    
    use SoftDeletes, UsesPredefinedValues;


    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'company_id',
                  'description',
                  'is_system_predefined'
              ];

    public $searchable = ['description'];

    public function company()
    {
        return $this->belongsTo('App\Company','company_id','id');
    }

    public function employees()
    {
        return $this->hasMany('App\Employee','branch_id','id');
    }

    public function recruitmentrequests()
    {
        return $this->hasMany('App\Recruitmentrequest','BranchId','id');
    }

    public function vacancy()
    {
        return $this->hasOne('App\Vacancy','BranchId','id');
    }


}