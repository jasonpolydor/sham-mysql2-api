<?php

namespace App\Traits;

use Fico7489\Laravel\Pivot\Traits\PivotEventTrait;
use OwenIt\Auditing\Auditable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

/**
 * https://gist.github.com/AbbyJanke/4d245b22dbcec277c207f033f37dae3b.
 */
trait MyAuditable
{
    use Auditable, PivotEventTrait;

    public static function bootMyAuditable()
    {
        static::pivotAttaching(function ($model, $relationName, $pivotIds, $pivotIdsAttributes) {});
        
        static::pivotAttached(function ($model, $relationName, $pivotIds, $pivotIdsAttributes) {
            if ($pivotIds) {
                return $model->savePivotAudit(
                    'Attached',
                    get_class($model->$relationName()->getRelated()),
                    $pivotIds[0],
                    $model->getKey()
                );
            }
        });
        
        static::pivotDetaching(function ($model, $relationName, $pivotIds) {});
        
        static::pivotDetached(function ($model, $relationName, $pivotIds) {
            if ($pivotIds) {
                return $model->savePivotAudit(
                    'Detached',
                    get_class($model->$relationName()->getRelated()),
                    $pivotIds[0],
                    $model->getKey()
                );
            }
        });
        
        static::pivotUpdating(function ($model, $relationName, $pivotIds, $pivotIdsAttributes) {});
        
        static::pivotUpdated(function ($model, $relationName, $pivotIds, $pivotIdsAttributes) {});
    }

    private function savePivotAudit($eventName, $relationClass, $relationId, $modelId)
    {
        $user = $this->resolveUser();
        return app('db')->table('audits_pivot')->insert([
                'event'          => $eventName,
                'user_id'        => $user->id,
                'user_type'      => get_class($user),
                'auditable_id'   => $modelId,
                'auditable_type' => $this->getMorphClass(),
                'relation_type'  => $relationClass,
                'relation_id'    => $relationId,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
    }

    /**
     * normal : $model->audits
     */
    private function getPivotAudits($type, $id)
    {
        return app('db')->table('audits_pivot')
                ->where('auditable_id', $id)
                ->where('auditable_type', $type)
                ->get()
                ->reverse();
    }

    /**
     * with relation : $model->auditsWithRelation
     */
    public function getAuditsWithRelationAttribute()
    {
        return $this->audits->map(function ($item) {
            $item['relations'] = $this->getPivotAudits($item->auditable_type, $item->auditable_id);

            return $item;
        });
    }

    /**
     * {@inheritdoc}
     */
    private function resolveUser()
    {
        $guards = Config::get('audit.user.guards', [
            'web',
            'api',
            'sham'
        ]);

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return Auth::guard($guard)->user();
            }
        }
    }
}
