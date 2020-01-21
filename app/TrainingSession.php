<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingSession extends Model
{

    use SoftDeletes;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'name',
                  'course_id',
                  'is_final'
              ];

    public $searchable = ['name'];

    public function course()
    {
        return $this->belongsTo('App\Course','course_id','id');
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class)->whereNull('date_terminated');
    }

}