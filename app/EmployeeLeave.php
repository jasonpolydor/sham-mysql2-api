<?php

namespace App;

use Plank\Mediable\Mediable;

class EmployeeLeave extends Model
{
    use Mediable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'absence_type_employee';

    protected $fillable = [
        'absence_type_id',
    ];
    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    public function Employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function AbsenceType()
    {
        return $this->belongsTo(AbsenceType::class);
    }

    public function CalendarEvents(){
        return $this->morphMany(CalendarEvent::class,'calendable');
    }

}
