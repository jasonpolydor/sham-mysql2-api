<?php

namespace App;

use Cohensive\Embed\Facades\Embed;
use Illuminate\Database\Eloquent\SoftDeletes;

class TopicVideoEmbed extends Model
{

    use SoftDeletes;


    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'topic_id',
                  'url'
              ];


    public function getVideoHtmlAttribute()
    {
        $embed = Embed::make($this->url)->parseUrl();

        if (!$embed)
            return '';

        $embed->setAttribute(['width'=>320, 'height'=>180]);
        return $embed->getHtml();
    }

    public function topic()
    {
        return $this->belongsTo('App\Topic','topic_id','id');
    }
}
