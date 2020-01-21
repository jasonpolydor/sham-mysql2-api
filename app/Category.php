<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /*public function products()
    {
        return $this->belongsToMany(Product::class);
    }*/

    public function items()
    {
        return $this->belongsToMany(Item::class);
    }

    public function shops()
    {
        return $this->belongsToMany(Shop::class, 'category_item');
    }

}
