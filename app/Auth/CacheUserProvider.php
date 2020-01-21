<?php

namespace App\Auth;

use App\User;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Support\Facades\Cache;

/**
 * Class CacheUserProvider
 * @package App\Auth
 */
class CacheUserProvider extends EloquentUserProvider
{
    /**
     * CacheUserProvider constructor.
     * @param HasherContract $hasher
     */
    public function __construct(HasherContract $hasher)
    {
        parent::__construct($hasher, User::class);
    }

    /**
     * @param mixed $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        $ret = Cache::get("user.$identifier");

        if ($ret == null) {
            return Cache::remember('user.' . $identifier, 360, function () use ($identifier) {

                //return parent::retrieveById($identifier);
    
                // code copied from EloquentUserProvider::retrieveById
                $model = $this->createModel();
                $ret = $model->newQuery()
                       ->where($model->getAuthIdentifierName(), $identifier)->get();
    
                return $ret->first();
                
            });
        } else {
            return $ret;
        }

    }
}