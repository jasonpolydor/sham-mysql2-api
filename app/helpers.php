<?php

function setting($key)
{
    return array_get(app('settings'), $key);
}

if (! function_exists('getAllowedActions')) {
    function getAllowedActions($sub_module_id){
        $temp = session('modulePermissions');

        try {
            $result = $temp[$sub_module_id];

            return $result;

        } catch(Exception $e) {
            
            return collect([]);
        }
    }
}