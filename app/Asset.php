<?php

namespace App;


use Illuminate\Database\Eloquent\SoftDeletes;
use San4io\EloquentFilter\Filters\LikeFilter;
use San4io\EloquentFilter\Filters\WhereFilter;

class Asset extends Model
{
    
    use SoftDeletes;



    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'name',
                  'asset_group_id',
                  'asset_supplier_id',
                  'tag',
                  'serial_no',
                  'purchase_price',
                  'purchase_date',
                  'years_to_depreciate',
                  'depreciation_rules_id',
                  'salvage_value',
                  'po_number',
                  'warranty_expiry_date',
                  'asset_condition_id',
                  'comments',
                  'is_available'
              ];

    public $searchable = [
        'name',
        'tag',
        'serial_no',
        'purchase_date',
        'years_to_depreciate',
        'depreciation_rules_id',
        'salvage_value',
        'po_number',
        'warranty_expiry_date',
        'comments',
        'is_available'
        ];
    
    /*
    protected $filterable = [
        'name' => LikeFilter::class,
        'tag' => LikeFilter::class,
        'serial_no' => LikeFilter::class,
        'purchase_price' => LikeFilter::class,
        'po_number' => LikeFilter::class,
        'warranty_expiry_date' => LikeFilter::class,
        'comments' => LikeFilter::class,
        'is_available' => WhereFilter::class
    ];
    */

    public function assetGroup()
    {
        return $this->belongsTo('App\AssetGroup','asset_group_id','id');
    }

    public function assetSupplier()
    {
        return $this->belongsTo('App\AssetSupplier','asset_supplier_id','id');
    }

    public function assetCondition()
    {
        return $this->belongsTo('App\AssetCondition','asset_condition_id','id');
    }

    public function assetEmployees()
    {
        return $this->belongsToMany('App\Employee')
                    ->select(['employee_id','date_in', 'date_out','comment']);
    }


}
