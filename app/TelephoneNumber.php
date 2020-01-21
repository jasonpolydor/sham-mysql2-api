<?php

namespace App;

use App\Traits\MyAuditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class TelephoneNumber extends Model implements AuditableContract
{
    
    use MyAuditable, SoftDeletes;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'employee_id',
                  'tel_number',
                  'telephone_number_type_id'
              ];

    protected $auditInclude = ['tel_number'];

     protected $auditableEvents = [
        'created', 'updated',
        'deleted', 'restored'
    ];
    
    public function employee()
    {
        return $this->belongsTo('App\Employee','employee_id','id');
    }

    public function telephoneNumberType()
    {
        return $this->belongsTo('App\TelephoneNumberType','telephone_number_type_id');
    }


}