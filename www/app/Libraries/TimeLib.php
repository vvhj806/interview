<?php

namespace App\Libraries;

use CodeIgniter\I18n\Time;

class TimeLib
{
    private $strToday = '';
    public function __construct()
    {
        $this->strToday = Time::parse('now', 'Asia/Seoul')->toLocalizedString('yyyyMMdd');
    }
    //$inputDate => Ymd || Y-m-d
    //return => '마감' || 'D-n'
    public function makeDay($endDate, $startDate = null): string
    {
        $timeEndDate = Time::parse($endDate, 'Asia/Seoul');
        $timeCurrent = Time::parse($startDate ? $startDate : $this->strToday, 'Asia/Seoul');

        $strDiffDate = $timeCurrent->difference($timeEndDate)->getDays();

        if ($strDiffDate >= 0) {
            ++$strDiffDate;
            $strDiffDate = "D-$strDiffDate";
        } else {
            $strDiffDate = '마감';
        }
        return $strDiffDate;
    }
    //$inputDate => Ymd || Y-m-d
    public function checkRegularTime($endDate, $startDate = null): bool
    {
        $timeEndDate = Time::parse($endDate, 'Asia/Seoul');
        $timeCurrent = Time::parse($startDate ? $startDate : $this->strToday, 'Asia/Seoul');

        $strDiffDate = $timeCurrent->difference($timeEndDate)->getDays();

        return $strDiffDate >= 0 ? true : false;
    }
}
