<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;

class CandidateInterviewer extends Model
{
    
    use SoftDeletes;

    protected $table = "candidate_interviewers";


    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'candidate_interview_recruitment_id',
                  'employee_id'
              ];
}