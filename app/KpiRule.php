<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class KpiRule extends Model
{
    
    use SoftDeletes;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'kpi_rules';

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
                  'name',
                  'description',
                  'kpi_lookup_model_id',
                  'target'
              ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
               'deleted_at'
           ];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * Get the systemModule for this model.
     */
    // public function model()
    // {
    //     return $this->belongsTo(KpiLookupModel::class, 'kpi_lookup_model_id');
    // }

    public function employees()
    {
        return $this->belongsToMany(Employee::class);
    }

    public function evaluations() {
        return $this->belongsToMany(KpiLookupModel::class, 'kpi_evaluation_models','kpi_rule_id','kpi_lookup_model_id')->withPivot(['id','value']);
    }
}
