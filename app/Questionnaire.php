<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class Questionnaire extends Model
{
    
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'questionnaires';

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
                'title',
                'date_start',
                'date_end',
                'data',
                'post_id'
    ];

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $searchable = [
        'title',
        'date_start',
        'date_end',
        'data',
        'post_id'
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
     * Get the systemModule for this model.
     */
    public function systemSubModule()
    {
        return $this->belongsTo('App\SystemSubModule','system_sub_module_id');
    }

    /**
     * Get the systemModule for this model.
     */
    public function questionnaireResults()
    {
        return $this->hasMany('App\QuestionnaireResult');
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class);
    }
}
