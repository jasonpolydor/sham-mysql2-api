<?php

namespace App;

class HistoryTeam extends Model
{
    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'history_teams';

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
                'team_id',
                'date_occurred',
              ];

    public function employee()
    {
        return $this->belongsTo('App\Employee','employee_id');
    }

    public function team()
    {
        return $this->belongsTo('App\Team','team_id');
    }
}
