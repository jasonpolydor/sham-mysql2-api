<?php

namespace App;

use San4io\EloquentFilter\Filters\LikeFilter;
use Illuminate\Database\Eloquent\SoftDeletes;

class Survey extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'surveys';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'title',
                  'date_start',
                  'date_end',
                  'final',
                  'form_id',
                  'author_sham_user_id',
                  'survey_status_id'
    ];

    public $searchable = ['title', 'date_start', 'date_end',];

    protected $filterable = [
        'title' => LikeFilter::class,
        'date_start' => LikeFilter::class,
        'date_end' => LikeFilter::class,
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];
    
    /**
     * Get the users for this model.
     */
    public function users()
    {
        return $this->belongsTo('App\User','author_sham_user_id','id');
    }

    public function forms()
    {
        return $this->belongsTo('App\Form','form_id','id');
    }

    public function SurveyResponse()
    {
        return $this->belongsTo('App\SurveyResponse','id','survey_id');
    }

    /**
     * Set the date_start.
     *
     * @param  string  $value
     * @return void
     */
    public function setDateStartAttribute($value)
    {
        $this->attributes['date_start'] = !empty($value) ? date($this->getDateFormat(), strtotime($value)) : null;
    }

    /**
     * Set the EndDate.
     *
     * @param  string  $value
     * @return void
     */
    public function setEndDateAttribute($value)
    {
        $this->attributes['EndDate'] = !empty($value) ? date($this->getDateFormat(), strtotime($value)) : null;
    }

    /**
     * Get date_start in array format
     *
     * @param  string  $value
     * @return array
     */
    public function getDateStartAttribute($value)
    {
        return date('Y-m-d', strtotime($value));
    }

    /**
     * Get EndDate in array format
     *
     * @param  string  $value
     * @return array
     */
    public function getEndDateAttribute($value)
    {
        return date('Y-m-d', strtotime($value));
    }

}
