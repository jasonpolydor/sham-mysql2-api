<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class ShamUser extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sham_users';

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
                  'username',
                  'password',
                  'email_address',
                  'cell_number',
                  'silence_start',
                  'silence_end'
              ];

    public $searchable = ['username', 'email_address'];

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


    public function systemModule()
    {
        return $this->belongsTo('App\SystemModule','system_module_id','id');
    }



}
