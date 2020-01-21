<?php

namespace App;

use App\Enums\TimelineEventType;

class TimelineManager extends Model
{
    public static function addRewardTimelineHistory($reward)
    {
        // Insert record in HistoryRewards table
        $historyRewardObj = new HistoryReward();
        $historyRewardObj->employee_id = $reward->employee_id;
        $historyRewardObj->reward_id = $reward->id;
        $historyRewardObj->date_occurred = $reward->date_received;
        $historyRewardObj->updated_by_employee_id = "";

        $historyRewardObj->save();

        // Insert record in Timelines Table
        self::addToTimeline($reward->employee_id,TimelineEventType::Reward, $historyRewardObj->id);

    }

    public static function addEmployeeTimelineHistory($employee)
    {
        $date_joined = $employee->date_joined;
        if($date_joined != null)
        {
            //employee_id,Joined,date_occurred,updated_by
            $historyJoinsTerminationObj = new HistoryJoinTermination();
            $historyJoinsTerminationObj->employee_id = $employee->id;
            $historyJoinsTerminationObj->is_joined = true;
            $historyJoinsTerminationObj->date_occurred = $employee->date_joined;
            $historyJoinsTerminationObj->updated_by_employee_id = "";

            $historyJoinsTerminationObj->save();

            self::addToTimeline($employee->id,TimelineEventType::JoinTermination, $historyJoinsTerminationObj->id);
        }

        $departmentid = $employee->department_id;
        if($departmentid != null)
        {
            $historyDepartmentObj = new HistoryDepartment();
            $historyDepartmentObj->employee_id =  $employee->id;
            $historyDepartmentObj->department_id =  $departmentid;
            $historyDepartmentObj->date_occurred = date('Y-m-d\TH:i:s');
            $historyDepartmentObj->updated_by_employee_id = "";

            $historyDepartmentObj->save();

            self::addToTimeline($employee->id,TimelineEventType::Department, $historyDepartmentObj->id);
        }

        $jobtitleid = $employee->job_title_id;
        if($jobtitleid != null)
        {
            $historyjobtitleObj = new HistoryJobTitle();
            $historyjobtitleObj->employee_id = $employee->id;
            $historyjobtitleObj->job_title_id = $jobtitleid;
            $historyjobtitleObj->date_occurred = date('Y-m-d\TH:i:s');
            $historyjobtitleObj->updated_by_employee_id = "";

            $historyjobtitleObj->save();

            self::addToTimeline($employee->id,TimelineEventType::JobTitle, $historyjobtitleObj->id);
        }

        $team_id = $employee->team_id;
        if($team_id != null)
        {
            $historyTeamObj = new HistoryTeam();
            $historyTeamObj->employee_id = $employee->id;
            $historyTeamObj->team_id = $team_id;
            $historyTeamObj->date_occurred = date('Y-m-d\TH:i:s');
            $historyTeamObj->updated_by_employee_id = "";

            $historyTeamObj->save();

            self::addToTimeline($employee->id,TimelineEventType::Team, $historyTeamObj->id);
        }
    }

    public static function updateEmployeeTimelineHistory($employee)
    {
        $terminationDate = $employee->date_terminated;
        $departmentid = $employee->department_id;
        $teamid = $employee->team_id;
        $jobtitleid = $employee->job_title_id;
        $selectedTerminationDate = "";
        
        $id = $employee->id;

        // Get last termination date from history table
        $arr = HistoryJoinTermination::where('employee_id','=', $id)->orderBy('id','desc')->get()->first();
        if($arr != null && !$arr->is_joined)
        {
            $selectedTerminationDate = date("Y-m-d", strtotime($arr->date_occurred));//$element->date_occurred;
        }

        // Get last departmentid from history table
        $lastDepartment = HistoryDepartment::where('employee_id','=', $id)->orderBy('id','desc')->get()->first();
        $selectedDepartmentid = optional($lastDepartment)->department_id;

        // Get last jobtitleid from history table
        $lastJobTitle = HistoryJobTitle::where('employee_id','=', $id)->orderBy('id','desc')->get()->first();
        $selectedJobtitleid = optional($lastJobTitle)->job_title_id;

        // Get last teamid from history table
        $lastTeam = HistoryTeam::where('employee_id','=', $id)->orderBy('id','desc')->get()->first();
        $selectedTeamid = optional($lastTeam)->team_id;

        // Add  new terminationdate if keyed termination date is not equal to historytermination date.
        if ($terminationDate != null) {
            if($terminationDate != $selectedTerminationDate)
            {
                //employee_id,Joined,date_occurred,updated_by
                $historyJoinsTerminationObj = new HistoryJoinTermination();
                $historyJoinsTerminationObj->employee_id = $employee->id;
                $historyJoinsTerminationObj->is_joined = false;
                $historyJoinsTerminationObj->date_occurred = $employee->date_terminated;
                $historyJoinsTerminationObj->updated_by_employee_id = "";

                $historyJoinsTerminationObj->save();

                self::addToTimeline($employee->id, TimelineEventType::JoinTermination, $historyJoinsTerminationObj->id);
            }
        }

        if($departmentid != null)
        {
            if($departmentid != $selectedDepartmentid)
            {
                $historyDepartmentObj = new HistoryDepartment();
                $historyDepartmentObj->employee_id = $employee->id;
                $historyDepartmentObj->department_id = $departmentid;
                $historyDepartmentObj->date_occurred = date('Y-m-d\TH:i:s');
                $historyDepartmentObj->updated_by_employee_id = "";

                $historyDepartmentObj->save();

                self::addToTimeline($employee->id, TimelineEventType::Department, $historyDepartmentObj->id);
            }
        }

        if($jobtitleid != null)
        {
            if($jobtitleid != $selectedJobtitleid)
            {
                $historyJobtitleObj = new HistoryJobTitle();
                $historyJobtitleObj->employee_id = $employee->id;
                $historyJobtitleObj->job_title_id = $jobtitleid;
                $historyJobtitleObj->date_occurred = date('Y-m-d\TH:i:s');
                $historyJobtitleObj->updated_by_employee_id = "";

                $historyJobtitleObj->save();

                self::addToTimeline($employee->id, TimelineEventType::JobTitle, $historyJobtitleObj->id);
            }
        }

        if($teamid != null)
        {
            if($teamid != $selectedTeamid)
            {
                $historyTeamObj = new HistoryTeam();
                $historyTeamObj->employee_id = $employee->id;
                $historyTeamObj->team_id = $teamid;
                $historyTeamObj->date_occurred = date('Y-m-d\TH:i:s');
                $historyTeamObj->updated_by_employee_id = "";

                $historyTeamObj->save();

                self::addToTimeline($employee->id, TimelineEventType::Team, $historyTeamObj->id);
            }
        }
    }

    public static function addDisciplinaryActionTimelineHistory($dispAction)
    {

        //{"@odata.context":"http:\/\/smartz-ham.azurewebsites.net\/odata\/$metadata#DisciplinaryActions\/$entity","id":5,"employee_id":104,
        //"Violationid":1,"ViolationDate":"2016-06-03T00:00:00Z","EmployeeStatement":"Employee Statement",
        //"EmployerStatement":"Employer Statement","Decision":"No decision has been taken","updated_by":"None"}
        // Insert record in HistoryRewards table
        
        $historyDispActionObj = new HistoryDisciplinaryAction();
        $historyDispActionObj->employee_id = $dispAction->employee_id;
        $historyDispActionObj->disciplinary_action_id = $dispAction->id;
        $historyDispActionObj->date_occurred = $dispAction->violation_date;
        $historyDispActionObj->updated_by_employeeid = "";

        $historyDispActionObj->save();

        // Insert record in Timelines Table
        self::addToTimeline($dispAction->employee_id,TimelineEventType::Disciplinary, $historyDispActionObj->id);
    }


    public static function addToTimeline($employee_id,$timelineEventyTypid,$eventid)
    {
        $timelineObj = new Timeline();
        $timelineObj->employee_id = $employee_id;
        $timelineObj->timeline_event_type_id = $timelineEventyTypid;
        $timelineObj->event_id =  $eventid;
        $timelineObj->event_date = date('Y-m-d\TH:i:s');
        
        $timelineObj->save();
    }

}