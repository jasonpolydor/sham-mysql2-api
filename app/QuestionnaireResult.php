<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionnaireResult extends Model
{
    
    use SoftDeletes;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'questionnaire_results';

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
                  'questionnaire_id',
                  'response_data',
                  'employee_id'
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
     * Get the questionnaire for this model.
     */
    public function questionnaire()
    {
        return $this->belongsTo('App\Questionnaire','questionnaire_id');
    }

    /**
     * Get the employee for this model.
     */
    public function employee()
    {
        return $this->belongsTo('App\Employee','employee_id');
    }

}
