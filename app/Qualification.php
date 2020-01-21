<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class Qualification extends Model
{
    
    use SoftDeletes;



    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'employee_id',
                  'reference',
                  'description',
                  'institution',
                  'obtained_on',
                  'student_no',
                  'deleted_at' /* helps to restore deleted records and have less deleted records */
              ];

    public function employee()
    {
        return $this->belongsTo('App\Employee','employee_id','id');
    }

    public function historyqualification()
    {
        return $this->hasOne('App\Historyqualification','QualificationId','id');
    }


}