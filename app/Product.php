<?php

namespace App;

use App\Traits\MyAuditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model implements AuditableContract
{

    use SoftDeletes, MyAuditable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';

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
                  'name',
                  'description'
              ];

    public $searchable = ['name', 'description'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    protected $auditInclude = [
        'name',
        'description'
    ];

    protected $auditableEvents = [
        'created', 'updated',
        'deleted', 'restored'
    ];


    public function Teams()
    {
        return $this->belongsToMany(Team::class);
    }

}
