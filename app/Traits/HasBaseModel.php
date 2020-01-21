<?php

/**
 * Created by PhpStorm.
 * User: TaroonG
 * Date: 6/8/2018
 * Time: 9:06 PM
 */

namespace App\Traits;

use Illuminate\Support\Facades\Schema;
use App\Support\Collection;
use Venturecraft\Revisionable\RevisionableTrait;

trait HasBaseModel
{
    public $excludedColumns = ['id', 'created_at', 'updated_at', 'deleted_at', 'password', 'remember_token', 'token'];

    public static function boot()
    {
        parent::boot();
    }
    
    public function getData($sortColumns = ['id' => 'asc'])
    {
        $obj = $this->newQuery();
        return $obj->ofSort($sortColumns)->paginate(10);
    }

    public function AddData($input)
    {
        return static::create($input);
    }

    public function findData($id)
    {
        return static::find($id);
    }

    public function updateData($id, $input)
    {
        $o = static::find($id);
        return $o->update($input);
    }

    public function destroyData($id)
    {
        return static::where('id', $id)->first()->delete();
    }

    public function scopeOfSort($query, $sort)
    {
        foreach ($sort as $column => $direction) {
            $query->orderBy($column, $direction);
        }

        return $query;
    }

    public function listMergeFieldColumns() {
        $columns = Schema::getColumnListing($this->table);
        return array_diff($columns, $this->excludedColumns);
    }
}