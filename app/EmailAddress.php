<?php

namespace App;

use App\Traits\MyAuditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailAddress extends Model implements AuditableContract
{
    
    use MyAuditable,  SoftDeletes;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'employee_id',
                  'email_address',
                  'email_address_type_id'
              ];
              
    protected $auditInclude = [];
    
    public function employee()
    {
        return $this->belongsTo('App\Employee','employee_id','id');
    }

    public function emailAddressType()
    {
        return $this->belongsTo('App\EmailAddressType','email_address_type_id','id');
    }


}