<?php

namespace App;

use Plank\Mediable\Mediable;

class CandidateInterviewAttachments extends Model
{
    use Mediable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'candidate_interview_recruitment';

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
                  'candidate_id',
                  'interview_id',
                  'recruitment_id',
                  'reasons',
                  'schedule_at',
                  'results',
                  'location',
                  'is_completed',
                  'status',
              ];
}
