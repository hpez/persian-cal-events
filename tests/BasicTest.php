<?php


namespace hpez\PersianCalEvent;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class BasicTest extends TestCase
{
    public function testJalali()
    {
        $result = PersianCalEvent::jalali(1398, 1, 1);
        $this->assertEquals($result->is_holiday, true);

        $result = PersianCalEvent::jalali(1398, 5, 7);
        $this->assertEquals($result->is_holiday, false);
    }

    public function testGregorian()
    {
        $result = PersianCalEvent::gregorian(2019, 8, 12);
        $this->assertEquals($result->is_holiday, true);

        $result = PersianCalEvent::gregorian(2019, 8, 11);
        $this->assertEquals($result->is_holiday, false);

        $result = PersianCalEvent::gregorian(new Carbon('2019-08-12'));
        $this->assertEquals($result->is_holiday, true);

        $result = PersianCalEvent::gregorian(new Carbon('first day of August 2019'));
        $this->assertEquals($result->is_holiday, false);
    }
}