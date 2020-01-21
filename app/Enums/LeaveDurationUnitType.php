<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class LeaveDurationUnitType extends Enum
{
    
    const Days = 0;
    const Hours = 1;

    /**
     * Get the description for an enum value
     *
     * @param  int  $value
     * @return string
     */

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::Days:
                return 'Days';
                break;
            case self::Hours:
                return 'Hours';
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
