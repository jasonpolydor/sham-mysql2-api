<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model
{
    

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'survey_responses';

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
                  'response',
                  'date_occurred'
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
     * Set the date_occurred.
     *
     * @param  string  $value
     * @return void
     */
    public function setDateOccurredAttribute($value)
    {
        $this->attributes['date_occurred'] = !empty($value) ? date($this->getDateFormat(), strtotime($value)) : null;
    }

    /**
     * Get date_occurred in array format
     *
     * @param  string  $value
     * @return array
     */
    public function getDateOccurredAttribute($value)
    {
        return date('j/n/Y', strtotime($value));
    }

    public function getResponseArray() {

        if (!isset ($this->response)) return array();
        return json_decode($this->response,TRUE);
    }

}
