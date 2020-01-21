<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ModuleQuestionType extends Enum
{
    const SingleChoice = 1;
    const MultipleChoice = 2;
    const OpenText = 3;

    /**
     * Get the description for an enum value
     *
     * @param  int  $value
     * @return string
     */
    public static function getDescription($value): string
    {
        switch ($value) {
            case self::SingleChoice:
                return 'SingleChoice';
                break;
            case self::MultipleChoice:
                return 'MultipleChoice';
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
