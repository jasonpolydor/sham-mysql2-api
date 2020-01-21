<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class NotificationRecurrenceType extends Enum
{
    const NoRecurrence = 1;
    const Daily = 2;
    const Weekly = 3;
    const Fortnightly = 4;
    const Monthly = 5;
    const Yearly = 6;

    /**
     * Get the description for an enum value
     *
     * @param  int  $value
     * @return string
     */

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::NoRecurrence:
                return 'No Recurrence';
                break;
            case self::Daily:
                return 'Daily';
                break;
            case self::Weekly:
                return 'Weekly';
                break;
            case self::Fortnightly:
                return 'Fortnightly';
                break;
            case self::Monthly:
                return 'Monthly';
                break;
            case self::Yearly:
                return 'Yearly';
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
