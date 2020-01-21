<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class SurveyStatusType extends Enum
{
    const Created = 1;
    const InProgress = 2;
    const Completed = 3;
    const Scheduled = 4;

    /**
     * Get the description for an enum value
     *
     * @param  int  $value
     * @return string
     */

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::Created:
                return 'Created';
                break;
            case self::InProgress:
                return 'In Progress';
                break;
            case self::Completed:
                return 'Completed';
                break;
            case self::Scheduled:
                return 'Scheduled';
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
