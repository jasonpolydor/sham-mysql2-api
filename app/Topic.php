<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Plank\Mediable\Mediable;

class Topic extends Model
{
    use Mediable;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'header',
                  'description',
                  'data',
              ];

    public $searchable = ['description'];

    public function modules()
    {
        return $this->belongsToMany('App\Module');
    }

    public function videoEmbeds()
    {
        return $this->hasMany('App\TopicVideoEmbed','topic_id','id');
    }
}
