<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{

    use SoftDeletes;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'is_public',
        'overview',
        'objectives',
        'passmark_percentage',
    ];

    public $searchable = ['description', 'overview', 'objectives', 'passmark_percentage', 'is_public'];

    public function topics()
    {
        return $this->belongsToMany(Topic::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

}
