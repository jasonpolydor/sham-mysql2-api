<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    
    use SoftDeletes;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'announcements';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'title',
                  'description',
                  'start_date',
                  'end_date',
                  'priority',
                  'announcement_status_id'
              ];

    public $searchable = ['title', 'description', 'start_date', 'end_date', 'announcement_status_id'];

    /**
     * Get the Announcement_Department for this model.
     */
    public function departments()
    {
        return $this->belongsToMany(Department::class)->withPivot('announcement_id');
    }

      public function employees()
    {
        return $this->belongsToMany(Employee::class);
    }
}
