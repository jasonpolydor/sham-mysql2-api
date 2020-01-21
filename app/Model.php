<?php
/**
 * Created by PhpStorm.
 * User: TaroonG
 * Date: 5/7/2018
 * Time: 8:51 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Support\Facades\Schema;
use App\Traits\HasBaseModel;
use Jedrzej\Searchable\SearchableTrait;
use Jedrzej\Searchable\Constraint;
use San4io\EloquentFilter\Traits\Filterable;
use San4io\EloquentFilter\Filters\WhereFilter;
use San4io\EloquentFilter\Filters\LikeFilter;
use Fico7489\Laravel\Pivot\Traits\PivotEventTrait;

class Model extends BaseModel
{
    use HasBaseModel, SearchableTrait, Filterable, PivotEventTrait;
}