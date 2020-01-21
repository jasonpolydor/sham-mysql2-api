<?php
namespace App\Enums;

use BenSampo\Enum\Enum;

final class LeaveStatusType extends Enum
{
    const status_pending = 0;
    const status_approved  = 1;
    const status_denied = 2;
    const status_cancelled = 3;

    /**
     * Get the description for an enum value
     *
     * @param  int  $value
     * @return string
     */

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::status_pending:
                return 'Pending';
                break;
            case self::status_approved:
                return 'Approved';
                break;
            case self::status_denied:
                return 'Denied';
                break;
            case self::status_cancelled:
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