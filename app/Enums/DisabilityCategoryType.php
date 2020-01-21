<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class DisabilityCategoryType extends Enum
{
    const Aids = 1;
    const Hearing = 2;
    const Learning = 3;
    const Mental = 4;
    const Other = 5;
    const Personality = 6;
    const Visual = 7;

    /**
     * Get the description for an enum value
     *
     * @param  int  $value
     * @return string
     */
    public static function getDescription($value): string
    {
        switch ($value) {
            case self::Aids:
                return 'Aids';
                break;
            case self::Hearing:
                return 'Hearing';
                break;
            case self::Learning:
                return 'Learning';
                break;
            case self::Mental:
                return 'Mental';
                break;
            case self::Other:
                return 'Other';
                break;
            case self::Personality:
                return 'Personality';
                break;
            case self::Visual:
                return 'Visual';
                break;
            default:
                return self::getKey($value);
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
