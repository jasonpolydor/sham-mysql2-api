<?php

use App\Employee;
use App\User;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;

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

if (! function_exists('notifyUsers')) {
    function notifyUsers($users, Notification $n) {
        \Notification::sendNow($users, $n);
    }
}

if (! function_exists('getManagerEmployeeIds')) {
    function getManagerEmployeeIds($manager_id){
        $employees_ids = Employee::where('line_manager_id', $manager_id)
            ->where(function ($q) {
                $q->where('date_terminated', '<=', date("Y-m-d"))
                    ->orWhereNull('date_terminated');
            })
            ->pluck('id')
            ->toArray();
        return $employees_ids;
    }
}

if (! function_exists('getDepartmentEmployees')) {
    function getDepartmentEmployees($department_id,$manager_id = null){
        if(empty($manager_id)){
            /*$employees_ids  = DB::table('employees')->select('id','first_name','surname')
                ->where(function($q){
                    $q->where('date_terminated','<=',date("Y-m-d"))
                        ->orWhereNull('date_terminated');
                })
                ->where('department_id', $department_id)
                ->whereNull('deleted_at')
                ->orderBy('first_name')
                ->get();
            */
            
            $query = User::leftJoin('employees', 'users.employee_id', '=', 'employees.id')
                     ->whereNull('employees.date_terminated')
                     ->select('users.*');

            if(is_array($department_id)){
                $query = $query->whereIn('employees.department_id', $department_id);
            } else {
                $query = $query->where('employees.department_id', $department_id);
            }

            $employees_ids  = $query->get();

        }else{
            $employees_ids  = DB::table('employees')->select('id','first_name','surname')
                ->where(function($q){
                    $q->where('date_terminated','<=',date("Y-m-d"))
                        ->orWhereNull('date_terminated');
                })
                ->where('department_id', $department_id)
                ->where('id','!=',$manager_id)
                ->whereNull('deleted_at')
                ->orderBy('first_name')
                ->get();
        }
        return $employees_ids;
    }
}

if (! function_exists('getDepartmentManagers')) {
    function getDepartmentManagers($department_id,$employee_id){
        $users_ids  = User::whereNull('users.deleted_at')
            ->where('employees.department_id', $department_id)
            ->where('job_titles.is_manager',1)
            ->where('users.employee_id','!=',$employee_id)
            ->where(function($q){
                $q->where('employees.date_terminated','<=',date("Y-m-d"))
                    ->orWhereNull('employees.date_terminated');
            })
            ->leftJoin('employees','users.employee_id','employees.id')
            ->leftJoin('job_titles','job_titles.id','employees.job_title_id')
            ->select("users.id")
            ->get();

        return $users_ids;
    }
}

if (! function_exists('getLinkedUsers')) {
    function getLinkedUsers($employee_ids){
        $user_ids  = User::whereIn('employee_id',$employee_ids)
            ->get();

        return $user_ids;
    }
}
