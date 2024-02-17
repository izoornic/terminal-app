<?php

namespace App\Http;

use Illuminate\Support\Carbon;

class Helpers
{

    public static function datumFormat($dbdate)
    {
        return Carbon::parse($dbdate)->setTimezone('Europe/Belgrade')->translatedFormat('d. m. Y. - G:i:s');
    }

    public static function datumFormatDan($dbdate)
    {
        return Carbon::parse($dbdate)->setTimezone('Europe/Belgrade')->translatedFormat("d. m. 'y.");
    }

    public static function datumFormatDanFullYear($dbdate)
    {
        return Carbon::parse($dbdate)->setTimezone('Europe/Belgrade')->translatedFormat("d. m. Y.");
    }

    public static function datumKalendarNow()
    {
       return Carbon::now()->format('Y-m-d');
    }

    public static function vremeKalendarNow()
    {
        return Carbon::now()->format('H:i:s');
    }

    public static function firstDayOfMounth($date)
    {
        return Carbon::parse($date)->startOfMonth()->toDateString();
    }

    public static function lastDayOfManth($date)
    {
        return Carbon::parse($date)->endOfMonth()->toDateString();
    }

    public static function addMonthsToDate($date, $no_of_mounths)
    {
        return Carbon::parse($date)->addMonths($no_of_mounths)->toDateString();
    }

    public static function addDaysToDate($date, $no_of_days)
    {
        return Carbon::parse($date)->addDays($no_of_days)->toDateString();
    }

    public static function nameOfTheMounth($date)
    {
        $tr = [
            'January'=>'januar',
            'February'=>'februar',
            'March' => 'mart',
            'April'=>'april',
            'May'=>'maj',
            'June'=>'jun',
            'July'=>'jul',
            'August'=>'avgust',
            'September'=>'septembar',
            'October'=>'oktobar',
            'November'=>'novembar',
            'December'=>'decembar'
        ];
        $name = Carbon::parse($date)->format('F');
        return strtr($name,$tr);
    }

    public static function yearNumber($date)
    {
        return Carbon::parse($date)->format('Y');
    }
    
    public static function numberOfDaysBettwen($startDate, $endDate)
    {
        $sDate = Carbon::parse($startDate);
        $eDate = Carbon::parse($endDate);
        
        return ($eDate > $sDate) ? $sDate->diffInDays($endDate) : false;
    }

    public static function numberOfMounthsBettwen($startDate, $endDate)
    {
        $sDate = Carbon::parse($startDate);
        $eDate = Carbon::parse($endDate);
        
        return ($eDate > $sDate) ? $sDate->diffInMonths($endDate) : false;
    }

    public static function isMonthCurrent($startDate)
    {
        if ($startDate == null) return false;
        $eDate = Carbon::parse($startDate);
        $sDate = Carbon::now();
        //dd($eDate, $sDate,  $sDate->diffInMonths($eDate));
        return ($sDate->diffInMonths($eDate) > 0) ? false : true; 
    }

    public static function monthDifference($krajLicence)
    {
        if ($krajLicence == null) return false;
        $eDate = Carbon::parse($krajLicence);
        $sDate = Carbon::now();

        $diff = $sDate->diffInMonths($eDate);
        $dayPass = ($sDate->gt($eDate)) ? true : false;
        
        if($dayPass) return -1;
        else return $diff;
    }

    public static function noOfDaysInMounth($date)
    {
        return Carbon::parse($date)->daysInMonth;
    }

    public static function compareDates($startDate, $endDate)
    {
        $sDate = Carbon::parse($startDate);
        $eDate = Carbon::parse($endDate); //->startOfDay();
        return $sDate->eq($eDate);
    }

    /**
     * [Description for dateGratherThan]
     * Koristi se samo u funkciji razduziDistributera() / RazduzenjeDistributerMesec
     *
     * @param mixed $startDate
     * @param mixed $endDate
     * 
     * @return [boolean]
     * 
     */
    public static function dateGratherOrEqualThan($startDate, $endDate)
    {
        $sDate = Carbon::parse($startDate);
        $eDate = Carbon::parse($endDate); //->startOfDay();
        return $sDate->gt($eDate) || $sDate->eq($eDate);
    }

    public static function equalGraterOrLessThan($startDate, $endDate)
    {
        $sDate = Carbon::parse($startDate);
        $eDate = Carbon::parse($endDate);

        if($sDate->eq($eDate)) return 'eq';
        if($sDate->gt($eDate)) return 'gt';
        if($sDate->lt($eDate)) return 'lt';
        else return 'err';
    }

}