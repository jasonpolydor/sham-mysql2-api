<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    public function items()
    {
        return $this->belongsToMany(Item::class, 'category_item');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_item');
    }

    public static function catalogCategories($shopId)
    {
        return static::with('categories.items')->find($shopId); 
    }
}