<?php

/**
 *  Copyright © 2016 Siberian Federal University
 * 
 *  This file is part of YConfs.
 *  
 *  YConfs is free software: you can redistribute it and/or modify it
 *  under the terms of the GNU General Public License,
 *  for details see http://yconfs.sfu-kras.ru/license. 
 */
class DateUtils {

    public static function today() {
        return mktime(0, 0, 0);
    }

    public static function yesterday($date){
        $date = strtotime('-1 day', $date);
        return mktime(0, 0, 0, date("m", $date), date("d", $date), date("Y", $date));
    }
    
    public static function tomorrow($date){
        $date = strtotime('+1 day', $date);
        return mktime(0, 0, 0, date("m", $date), date("d", $date), date("Y", $date));
    }
    
    public static function startDay($date) {
        return mktime(0, 0, 0, date("m", $date), date("d", $date), date("Y", $date));
    }
    
    public static function endDay($date) {
        $date = strtotime('+1 day', $date);
        return mktime(0, 0, 0, date("m", $date), date("d", $date), date("Y", $date))-1;
    }

    protected static function fixDateFormat($dateFormat) {
        if ('MMM d, y' == $dateFormat) {
            return 'MMM d, yyyy';
        }
        return $dateFormat;
    }

    public static function dateFormat() {
        return DateUtils::fixDateFormat(Yii::app()->locale->dateFormat);
    }

    public static function timeFormat() {
        return 'HH:mm';
    }

    public static function dateTimeFormat() {
        return DateUtils::fixDateFormat(Yii::app()->locale->dateFormat) . ' ' . DateUtils::timeFormat();
    }

    //  UTS dateFormat convertion to JuiDatePicker format
    protected static $datePattern = array(
        'MMM d, yyyy' => 'M d, yy',
        'dd.MM.yyyy' => 'dd.mm.yy',
        'dd/MM/yyyy' => 'dd/mm/yy');

    public static function JuiDateFormat() {
        return DateUtils::$datePattern[DateUtils::dateFormat()];
    }

    public static function JuiTimeFormat() {
        return 'hh:mm';
    }

    public static function getDateStr($date) {
        if (!$date) {
            return '';
        }
        $dateStr = Yii::app()->locale->dateFormatter->format(DateUtils::dateFormat(), $date);
        return $dateStr;
    }

    public static function getTimeStr($date) {
        if (!$date) {
            return '';
        }
        $dateStr = Yii::app()->locale->dateFormatter->format(DateUtils::timeFormat(), $date);
        return $dateStr;
    }

    public static function parseDate($dateStr) {
        $date = CDateTimeParser::parse($dateStr, DateUtils::dateFormat());
        if (!$date) {
            $date = NULL;
        }
        return $date;
    }

    public static function parseTime($timeStr) {
        $date = CDateTimeParser::parse($timeStr, DateUtils::timeFormat());
        if (!$date) {
            $date = NULL;
        }
        return $date;
    }

}

?>
