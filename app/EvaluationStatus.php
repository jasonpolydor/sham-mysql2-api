<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class EvaluationStatus extends Model
{
    
    use SoftDeletes;



    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'description'
              ];

    public function evaluations()
    {
        return $this->hasMany('App\Evaluation','evaluation_status_id','id');
    }


}