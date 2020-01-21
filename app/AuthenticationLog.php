<?php

namespace App;

use App\Traits\Paginatable;
use San4io\EloquentFilter\Filters\LikeFilter;
use San4io\EloquentFilter\Filters\WhereFilter;

class AuthenticationLog extends Model
{
    use Paginatable;
    
    protected $table = "authentication_log";
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ip_address',
        'user_agent',
        'login_at',
        'logout_at',
    ];

    public $searchable = [ 
        'ip_address',
        'login_at',
        'logout_at',
    ];

    /*protected $filterable = [
        'ip_address' => LikeFilter::class,
        'login_at' => WhereFilter::class,
        'logout_at' => LikeFilter::class,
    ];*/
}