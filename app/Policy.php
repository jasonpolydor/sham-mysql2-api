<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;
use Plank\Mediable\Mediable;

class Policy extends Model
{
    use Mediable;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'title',
                  'content',
                  'policy_category_id',
                  'expires_on'
              ];

    public $searchable = ['title', 'policy_category_id'];

    public function policyCategory()
    {
        return $this->belongsTo('App\PolicyCategory','policy_category_id','id');
    }

    public function policydocument()
    {
        return $this->hasOne('App\Policydocument','policy_id','id');
    }

    public function ComplianceEmployees()
    {
        return $this->morphMany(ComplianceEmployee::class,'acknowledgable');
    }

}