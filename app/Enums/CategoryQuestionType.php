<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class CategoryQuestionType extends Enum
{
    const OPEN_TEXT = 1;
    const SELECT_ONE = 2;
    const SELECT_MANY = 3;

    /**
     * Get the description for an enum value
     *
     * @param  int  $value
     * @return string
     */
    public static function getDescription($value): string
    {
        switch ($value) {
            case self::OPEN_TEXT:
                return 'Open Text';
                break;
            case self::SELECT_ONE:
                return 'Select One';
                break;

            case self::SELECT_MANY:
                return 'Select Many';
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
