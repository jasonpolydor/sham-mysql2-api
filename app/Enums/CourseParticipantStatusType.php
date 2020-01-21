<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class CourseParticipantStatusType extends Enum
{
    const Just_Enrolled = 1;
    const In_Progress = 2;
    const Completed = 3;

    /**
     * Get the description for an enum value
     *
     * @param  int  $value
     * @return string
     */

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::Just_Enrolled:
                return 'Just Enrolled';
                break;
            case self::In_Progress:
                return 'In Progress';
                break;
            case self::Completed:
                return 'Completed';
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
