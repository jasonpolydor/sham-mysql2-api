<?php

namespace App;

use San4io\EloquentFilter\Filters\LikeFilter;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetGroup extends Model
{
    
    use SoftDeletes;

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

    protected $filterable = [
        'name' => LikeFilter::class,
        'description' => LikeFilter::class
    ];

    public function assets()
    {
        return $this->hasMany('App\Asset','asset_group_id','id');
    }


}