<?php

namespace App;

class HistoryReward extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'history_rewards';

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
                  'reward_id',
                  'date_occurred'
              ];

    public function employee()
    {
        return $this->belongsTo('App\Employee','employee_id');
    }

    public function reward()
    {
        return $this->belongsTo('App\Reward','reward_id');
    }

}
