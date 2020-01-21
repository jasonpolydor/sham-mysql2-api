<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class DepreciationRulesType extends Enum
{
    const straight_line = 1;
    const double_decline = 2;
    const production_unit = 3;
    const sum_of_years_digits = 4;
    /**
     * Get the description for an enum value
     *
     * @param  int  $value
     * @return string
     */

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::straight_line:
                return 'Straight Line';
                break;
            case self::double_decline:
                return 'Double declining balance';
                break;
            case self::production_unit:
                return 'Units of production';
                break;
            case self::sum_of_years_digits:
                return 'Sum of years’ digits';
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
