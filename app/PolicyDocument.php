<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class PolicyDocument extends Model
{
    
    use SoftDeletes;



    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'policy_id',
                  'name',
                  'content'
              ];

    /**
     * Get the policy for this model.
     */
    public function policy()
    {
        return $this->belongsTo('App\Policy','policy_id');
    }


}