<?php

namespace App;

use App\Traits\MyAuditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model implements AuditableContract
{

    use MyAuditable,  SoftDeletes;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'employee_id',
                  'unit_no',
                  'complex',
                  'addr_line_1',
                  'addr_line_2',
                  'addr_line_3',
                  'addr_line_4',
                  'city',
                  'province',
                  'zip_code',
                  'country_id',
                  'address_type_id',
                  'is_active'
              ];

    protected $auditInclude = ['unit_no',
                  'complex',
                  'addr_line_1',
                  'addr_line_2',
                  'addr_line_3',
                  'addr_line_4',
                  'city',
                  'province',
                  'zip_code'];
    protected $auditableEvents = [
        'created', 'updated',
        'deleted', 'restored'
    ];

    public function employee()
    {
        return $this->belongsTo('App\Employee','employee_id');
    }

    public function country()
    {
        return $this->belongsTo('App\Country','country_id');
    }

    public function addressType()
    {
        return $this->belongsTo('App\AddressType','address_type_id');
    }


}