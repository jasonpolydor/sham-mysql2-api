<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;
use San4io\EloquentFilter\Filters\LikeFilter;

class Reward extends Model
{
    
    use SoftDeletes;



    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'employee_id',
                  'description',
                  'rewarded_by',
                  'date_received'
              ];

    public $searchable = ['description', 'rewarded_by', 'date_received'];

    protected $filterable = [
        'description' => LikeFilter::class,
        'rewarded_by' => LikeFilter::class,
        'date_received' => LikeFilter::class
    ];

    public function employee()
    {
        return $this->belongsTo('App\Employee','employee_id');
    }


}