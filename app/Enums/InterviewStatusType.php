<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class InterviewStatusType extends Enum
{
    const COMPLETED = 1;
    const NOTCOMPLETED = 2;
    const CANCELLED = 3;
    /**
     * Get the description for an enum value
     *
     * @param  int  $value
     * @return string
     */

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::COMPLETED:
                return 'Completed';
                break;
            case self::NOTCOMPLETED:
                return 'Not Completed';
                break;
            case self::CANCELLED:
                return 'Cancelled';
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
