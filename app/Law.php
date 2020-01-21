<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Plank\Mediable\Mediable;

class Law extends Model
{
    use Mediable;
    use SoftDeletes;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'main_heading',
                  'sub_heading',
                  'country_id',
                  'law_category_id',
                  'content',
                  'is_public',
                  'expires_on'
              ];

    public $searchable = ['main_heading', 'country_id', 'law_category_id'];

    public function country()
{
    return $this->belongsTo('App\Country','country_id','id');
}

    public function lawCategory()
    {
        return $this->belongsTo('App\LawCategory','law_category_id','id');
    }

    public function lawDocuments()
    {
        return $this->hasMany('App\LawDocument','law_id','id');
    }

    public function complianceEmployees(){
        return $this->morphMany(ComplianceEmployee::class,'acknowledgable');
    }

}