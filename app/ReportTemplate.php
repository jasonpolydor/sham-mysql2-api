<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class ReportTemplate extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'report_templates';

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
                  'system_module_id',
                  'source',
                  'title',
                  'order'
              ];

    public $searchable = ['source', 'title', 'order'];

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


    public function systemModule()
    {
        return $this->belongsTo('App\SystemModule','system_module_id','id');
    }




}
