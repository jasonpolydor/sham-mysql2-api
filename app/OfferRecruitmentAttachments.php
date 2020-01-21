<?php

namespace App;

use Plank\Mediable\Mediable;

class OfferRecruitmentAttachments extends Model
{
    use Mediable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'offer_recruitment';

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
                  'offer_id',
                  'recruitment_id',
                  'signed_on',
                  'comments',
              ];
}
