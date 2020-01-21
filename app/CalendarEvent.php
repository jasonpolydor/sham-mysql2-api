<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalendarEvent extends Model
{
    //events for manager only
    const manager_only = 1;

    protected  $fillable = ['calendable_id','calendable_type'];

    public function calendable()
    {
        return $this->morphTo();
    }
}
