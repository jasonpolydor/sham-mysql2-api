<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model as BaseModel;

class KpiEvaluationModel extends BaseModel
{

    protected $table = 'kpi_evaluation_models';

    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kpi_rule_id',
        'kpi_lookup_model_id',
        'value'
    ];

    public $timestamps = false;
    
    public function model(){
        return $this->belongsTo(KpiLookupModel::class);
    }

}