<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class PolicyCategory extends Model
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

    public $searchable = ['description'];

    public function policies()
    {
        return $this->hasMany('App\Policy','policy_category_id','id');
    }


}