<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use San4io\EloquentFilter\Filters\LikeFilter;

class AssetSupplier extends Model
{
    
    use SoftDeletes;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'name',
                  'address1',
                  'address2',
                  'address3',
                  'address4',
                  'telephone',
                  'email_address',
                  'comments'
              ];

    public $searchable = ['name', 'email_address', 'comments', 'telephone'];

    protected $filterable = [
        'name' => LikeFilter::class,
        'email_address' => LikeFilter::class,
        'comments' => LikeFilter::class,
        'telephone' => LikeFilter::class
    ];
  
}