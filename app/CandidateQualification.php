<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class CandidateQualification extends Model
{
    
    use SoftDeletes;



    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'candidate_id',
                  'reference',
                  'description',
                  'institution',
                  'obtained_on',
                  'student_no',
                  'deleted_at'
              ];

    public function candidate()
    {
        return $this->belongsTo('App\Candidate','candidate_id','id');
    }

}