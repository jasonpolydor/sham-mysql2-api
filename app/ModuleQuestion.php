<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModuleQuestion extends Model
{

    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'module_questions';

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
                  'module_question_type_id',
                  'title',
                  'points'
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

    protected static function boot() {
	    parent::boot();

	    static::created(function($item) {
            if($item->dbId == false){
                $item->dbId = $item->id;
            }
        });

        static::deleting(function($item) {
            $item->questionChoices()->delete();
        });
	}

    /**
     * Get the moduleQuestionType for this model.
     */
    public function moduleQuestionType()
    {
        return $this->belongsTo('App\ModuleQuestionType','module_question_type_id','id');
    }

    /**
     * Get the moduleQuestionType for this model.
     */
    public function questionChoices()
    {
        return $this->hasMany('App\ModuleQuestionChoice');
    }

}
