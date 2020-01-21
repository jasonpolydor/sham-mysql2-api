<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class DayType extends Enum
{
    const Monday = 1;
    const Tuesday = 2;
    const Wednesday = 3;
    const Thursday = 4;
    const Friday = 5;
    const Saturday = 6;
    const Sunday = 7;

    /**
     * Get the description for an enum value
     *
     * @param  int  $value
     * @return string
     */

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::Monday:
                return 'Monday';
                break;
            case self::Tuesday:
                return 'Tuesday';
                break;
            case self::Wednesday:
                return 'Wednesday';
                break;
            case self::Thursday:
                return 'Thursday';
                break;
            case self::Friday:
                return 'Friday';
                break;
            case self::Saturday:
                return 'Saturday';
                break;
            case self::Sunday:
                return 'Sunday';
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
