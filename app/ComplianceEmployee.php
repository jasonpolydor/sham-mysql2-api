<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplianceEmployee extends Model
{

    protected  $fillable = ['acknowledgable_id','acknowledgable_type','created_at'];

    public function acknowledgable()
    {
        return $this->morphTo();
    }
}
