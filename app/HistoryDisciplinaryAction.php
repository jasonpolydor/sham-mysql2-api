<?php

namespace App;


class HistoryDisciplinaryAction extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'history_disciplinary_actions';

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
        'employee_id',
        'disciplinary_action_id',
        'date_occurred'
    ];

    public function employee()
    {
        return $this->belongsTo('App\Employee','employee_id');
    }

    public function disciplinaryAction()
    {
        return $this->belongsTo('App\DisciplinaryAction','disciplinary_action_id');
    }

}
