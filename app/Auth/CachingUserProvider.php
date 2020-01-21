<?php

namespace App\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class CachingUserProvider extends EloquentUserProvider
{

    /**
     * The cache instance.
     *
     * @var Repository
     */
    protected $cache;

    /**
     * Create a new database user provider.
     *
     * @param  \Illuminate\Contracts\Hashing\Hasher  $hasher
     * @param  string  $model
     * @param  Repository  $cache
     * @return void
     */
    public function __construct(HasherContract $hasher, $model, Repository $cache)
    {
        $this->model = $model;
        $this->hasher = $hasher;
        $this->cache = $cache;
    }

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed  $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        return $this->cache->tags($this->getModel())->remember('user_by_id_'.$identifier, 180, function () use ($identifier) {
          $model = $this->createModel();
          return $model->newQuery()
            /*->with('roles', 'permissions', 'profile')*/
            ->where($model->getAuthIdentifierName(), $identifier)
            ->first();
        });
    }
}