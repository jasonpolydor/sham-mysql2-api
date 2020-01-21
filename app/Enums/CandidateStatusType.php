<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class CandidateStatusType extends Enum
{
    const APPLIED = 0;
    const INTERVIEWING = 1;
    const OFFER = 2;
    const CONTRACT = 3;
    const HIRED = 4;

    /**
     * Get the description for an enum value
     *
     * @param  int  $value
     * @return string
     */

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::APPLIED:
                return 'Applied';
                break;
            case self::INTERVIEWING:
                return 'Interviewing';
                break;
            case self::OFFER:
                return 'Offer';
                break;
                case self::CONTRACT:
                return 'Contract';
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
