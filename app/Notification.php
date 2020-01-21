<?php

namespace App;


class Notification extends Model
{

    protected $table = 'notifications';

    protected $casts = ['id' => 'string'];

    public function employeeNotifications()
    {
        return $this->belongsToMany(Employee::class);
    }

}
