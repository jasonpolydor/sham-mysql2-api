<?php
/**
 * Created by PhpStorm.
 * User: TaroonG
 * Date: 2016-10-03
 * Time: 12:50 PM
 */

namespace App;

use \Carbon\Carbon;

class DateHelper
{

    public static $date;

    public function __construct()
    {
        // for a strange reason, this is not working, the constructor not called
        static::$date = Carbon::today();
    }

    public static function todayInRangeIncluded($sStartDate, $sEndDate) {

        if (empty($sStartDate) || empty($sEndDate)) {
            return false;
        }

        $date = Carbon::today();
        $cbSt = new Carbon($sStartDate);
        $cbEd = new Carbon($sEndDate);

        //echo ' todayInRangeIncluded: ', '  ', $cbSt->toDateString(), ' ', $cbEd->toDateString(), '<br>';
        $res = (bool) (($date->eq($cbSt) || $date->eq($cbEd)) ||
                       ($date->gte($cbSt) && $date->lte($cbEd)));

        return $res;
    }

    public static function isBirthday($sDateA, $sDateB = '') {
        if (empty($sDateA)) {
            return false;
        }

        $cbDateA = new Carbon($sDateA);
        if (empty($sDateB)) {
            $res = $cbDateA->isBirthday();
        } else {
            $cbDateB = new Carbon($sDateB);
            $res = $cbDateA->isBirthday($cbDateB);
        }

        return $res;
    }

    public static function isTodayBefore($sDate='') {
        if (empty($sDate)) {
            return false;
        }

        $date = Carbon::today();
        $cb = new Carbon($sDate);
        $res = (bool) $date->lt($cb);

        return $res;
    }

    public static function isTodayIncluded($sDate='') {
        if (empty($sDate)) {
            return false;
        }

        $date = Carbon::today();
        $cb = new Carbon($sDate);
        $res = (bool) $date->lte($cb);

        return $res;
    }

    public static function adjustCarbonObjTimeZone($obj, $timeZone = 'GMT') {
        $serverOffset = $obj->getOffset();
        // add the offset in seconds back to GMT time
        // GMT time is +00:00 as timezone
        $obj->setTimezone($timeZone);
        $obj->addSeconds($serverOffset);
        // the datetime string now has +00:00 as timezone, but with the time adjusted

        return $obj;
    }

    public static function secondsToTimeFormatter($t, $includeSeconds=false, $f=':') // t = seconds, f = separator
    {
        if ($includeSeconds) {
            return sprintf("%02d%s%02d%s%02d", floor($t/3600), $f, ($t/60)%60, $f, $t%60);
        } else {
            return sprintf("%02d%s%02d", floor($t/3600), $f, ($t/60)%60);
        }

    }


}