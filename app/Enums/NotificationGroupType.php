<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class NotificationGroupType extends Enum
{
    const Administrators = 1;
    const Training = 2;
    const Employee = 3;
    const TestingGroup = 4;
    const RCS = 5;

    /**
     * Get the description for an enum value
     *
     * @param  int  $value
     * @return string
     */

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::Administrators:
                return 'Administrators';
                break;
            case self::Training:
                return 'Training';
                break;
            case self::Employee:
                return 'Employee';
                break;
            case self::TestingGroup:
                return 'Testing group';
                break;
            case self::RCS:
                return 'RCS';
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
