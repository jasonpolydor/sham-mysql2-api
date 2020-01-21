<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class TimelineEventType extends Enum
{
    const JobTitle = 1;
    const Department = 2;
    const Disciplinary = 3;
    const Reward = 4;
    const Qualification = 5;
    const JoinTermination = 6;
    const Training = 7;
    const Team = 8;

        /**
     * Get the description for an enum value
     *
     * @param  int  $value
     * @return string
     */

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::JobTitle:
                return 'Job Title';
                break;
            case self::Department:
                return 'Department';
                break;
            case self::Disciplinary:
                return 'Disciplinary Action';
                break;
            case self::Reward:
                return 'Reward';
                break;
            case self::Qualification:
                return 'Qualification';
                break;
            case self::JoinTermination:
                return 'Join/Termination Date';
                break;
            case self::Training:
                return 'Training';
                break;
            case self::Team:
                return 'Team';
                break;
            default:
                return  self::getKey($value);
        }
    }

    public static function ddList(){
        $values = self::getValues();

        $ret = array_combine( $values,
            array_map(function($v){
                return static::getDescription($v);
            }, $values));


        return $ret;
    }

    public static function keyValueArrayList() {
        $temp = static::ddList();
        $ret = array();

        foreach($temp as $k => $v)
        {
            $ret[] = array('key' => $k, 'value' => $v);
        }

        return $ret;
    }
}
