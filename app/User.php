<?php

namespace App;

use App\Traits\HasBaseModel;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use App\Events\UserAmended;
use Illuminate\Database\Eloquent\SoftDeletes;
Use Carbon\Carbon;
use Jedrzej\Searchable\SearchableTrait;
use San4io\EloquentFilter\Filters\LikeFilter;
use Illuminate\Database\Eloquent\Builder;
use Jedrzej\Searchable\Constraint;
use San4io\EloquentFilter\Traits\Filterable;
use Yadahan\AuthenticationLog\AuthenticationLogable;

class User extends Authenticatable
{
    use SoftDeletes, Notifiable, HasBaseModel, AuthenticationLogable, SearchableTrait, Filterable;

    protected $dispatchesEvents = [
        'saved' => UserAmended::class,
        'deleted' => UserAmended::class,
        'restored' => UserAmended::class,
    ];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'cell_number',
        'sham_user_profile_id',
        'employee_id',
        'silence_start',
        'silence_end'
    ];


    public $searchable = ['username', 'email', 'name'];

    protected $filterable = [
        'username' => LikeFilter::class,
        'email' => LikeFilter::class,
        'name' => LikeFilter::class,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    
    public function shamUserProfile()
    {
        return $this->hasOne('App\ShamUserProfile', 'id', 'sham_user_profile_id');
    }

    public function getAuthorisedModules()
    {
        $retVal = array();
        
        /*
		$permissions = \App\ShamUserProfilesSubModulePermission::selectWithExpand(['SystemSubModule'], "SystemSubModule(\$select=Id,;\$expand=SystemModule(\$select=Id))", "ShamUserProfileId eq ".$this->ShamUserProfileId."and SystemSubModule/Active eq true and SystemSubModule/SystemModule/Active eq true");
		if ($permissions != null && property_exists($permissions,'value')) {
			foreach ($permissions->value as $permissionItem) {
				$retVal[$permissionItem->SystemSubModule->SystemModule->Id][$permissionItem->SystemSubModule->Id] = 1;
			}
        }
        */
        

		return $retVal;

    }

    public function employee()
    {
        return $this->hasOne('App\Employee','id','employee_id');
    }

    /**
     * Scope a query to only include matching Sham User Profile.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfProfile($query, $category)
    {
        return $query->where('sham_user_profile_id', $category);
    }

    protected function processNameFilter(Builder $builder, Constraint $constraint)
    {
        // this logic should happen for LIKE/EQUAL operators only
        if ($constraint->getOperator() === Constraint::OPERATOR_LIKE || $constraint->getOperator() === Constraint::OPERATOR_EQUAL) {

            $builder->with('employee')
                ->whereHas('employee',function ($q) use ($constraint){
                    $q->where('employees.first_name', $constraint->getOperator(), $constraint->getValue())
                        ->orWhere('employees.surname', $constraint->getOperator(), $constraint->getValue());
                });

            return true;
        }
        return false;
    }

}
