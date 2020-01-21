<?php

namespace App;

use App\Traits\UsesPredefinedValues;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetCondition extends Model
{
    use SoftDeletes, UsesPredefinedValues;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'asset_conditions';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

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

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];
    



}
