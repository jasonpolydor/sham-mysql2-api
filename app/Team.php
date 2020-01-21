<?php

namespace App;

use App\Traits\MyAuditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model implements AuditableContract
{
    
    use SoftDeletes, MyAuditable;



    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'description',
                  'time_group_id'
              ];

    public $searchable = ['description'];

    protected $auditInclude = [
        'description',
        'time_group_id'
    ];

    protected $auditableEvents = [
        'created', 'updated',
        'deleted', 'restored'
    ];

    public function timeGroup()
    {
        return $this->belongsTo('App\TimeGroup','time_group_id','id');
    }

    public function employees()
    {
        return $this->hasMany('App\Employee','team_id','id');
    }

    public function teamProducts()
    {
        return $this->hasMany('App\TeamProduct','team_id','id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

}