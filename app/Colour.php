<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class Colour extends Model
{
    
    use SoftDeletes;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'colours';

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
                  'code'
              ];

    public function absenceTypes()
    {
        return $this->hasMany('App\AbsenceType');
    }

}
