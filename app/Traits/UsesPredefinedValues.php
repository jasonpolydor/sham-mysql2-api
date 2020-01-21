<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait UsesPredefinedValues
{
    public static function boot()
    {
        parent::boot();
    
        static::addGlobalScope('system_predefined', function (Builder $builder) {
            $builder->where('is_system_predefined', '=', 0);
        });
    }
}