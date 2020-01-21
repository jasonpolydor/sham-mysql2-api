<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class KpiLookupModel extends Model
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
    protected $table = 'kpi_lookup_models';

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
                  'table_name',
                  'description',
                  'sql_statement',
                  'is_filter_required'
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
    

    public static function modelsList()
    {
        $temp = static::
                select([DB::raw('DISTINCT kpi_lookup_models.display_name AS table_name'), 
                        'description', 'id'
                ])
                ->whereNull('kpi_lookup_models.deleted_at')
                ->get();
                
        return $temp;
    }

    public function evaluations() {
        return $this->hasMany(KpiEvaluationModel::class);
    }

}
