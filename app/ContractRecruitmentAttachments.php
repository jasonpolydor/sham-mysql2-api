<?php

namespace App;

use Plank\Mediable\Mediable;

class ContractRecruitmentAttachments extends Model
{
    use Mediable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contract_recruitment';

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
                  'contract_id',
                  'recruitment_id',
                  'signed_on',
                  'start_date',
                  'comments',
                  'master_copy'
              ];
}
