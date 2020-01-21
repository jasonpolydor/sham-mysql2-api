<?php

namespace App;

use App\Traits\UsesPredefinedValues;
use Illuminate\Database\Eloquent\SoftDeletes;

class DisciplinaryDecision extends Model
{

    use SoftDeletes, UsesPredefinedValues;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'disciplinary_decisions';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    public $searchable = [];

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'description',
                  'is_system_predefined'
              ];

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
    
    /**
     * Get the disciplinaryActions for this model.
     */
    public function disciplinaryActions()
    {
        return $this->hasMany('App\DisciplinaryAction','disciplinary_decision_id','id');
    }


    /**
     * Get created_at in array format
     *
     * @param  string  $value
     * @return array
     */
    public function getCreatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

    /**
     * Get updated_at in array format
     *
     * @param  string  $value
     * @return array
     */
    public function getUpdatedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

    /**
     * Get deleted_at in array format
     *
     * @param  string  $value
     * @return array
     */
    public function getDeletedAtAttribute($value)
    {
        return date('j/n/Y g:i A', strtotime($value));
    }

}
