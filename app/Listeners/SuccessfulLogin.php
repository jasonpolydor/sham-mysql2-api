<?php

namespace App\Listeners;

use App\User;
use App\ShamUserProfile;
use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {

        if($event->user instanceof \App\User){

            $profileId = $event->user->sham_user_profile_id;
            $s = ShamUserProfile::find($profileId);
            $allowedModules = $s->listMatrix();
            //first group by system_sub_module_id
            $perms = $s->shamPermissions->groupBy(function($item, $key){
                return $item['pivot']['system_sub_module_id'];
            });
            $groupedPerms = $perms->map(function(&$val, $key){
                // $val is an array of permissions
                return $val->map(function(&$v, $k){
                    return $v->alias;
                });
            });
            session(['allowedModules' => $allowedModules, 'modulePermissions' => $groupedPerms]);
        }

    }
}
