<?php namespace hpez\PersianCalEvent;

use Carbon\Carbon;
use Morilog\Jalali\CalendarUtils;

/**
*
*  @author Hassan Pezeshk
*/
class PersianCalEvent
{

    /**
     * @param int $y
     * @param int $m
     * @param int $d
     * @return array
     */
    private static function crawl($y, $m, $d)
    {
        $handle = curl_init();

        $url = "http://www.time.ir/fa/event/list/0/$y/$m/$d";

        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_FAILONERROR, true);

        $output = curl_exec($handle);

        if (curl_errno($handle)) {
            echo curl_error($handle); die();
        }

        curl_close($handle);

        if (strpos($output, 'eventHoliday') !== false) {
            $start = strpos($output, '</span>', strpos($output, 'eventHoliday'));
            $start += 7;
            $end = strpos($output, '<span', $start);
            $cause = substr($output, $start, $end - $start);
            $cause = str_replace("\n", '', $cause);
            $cause = str_replace("\r", '', $cause);
            $cause = str_replace('"', '', $cause);
            $cause = trim($cause);
            return ['is_holiday' => true, 'cause' => $cause];
        }

        return ['is_holiday' => false];
    }

    /**
     * @param int $y
     * @param int $m
     * @param int $d
     * @return array
     */
    public static function jalali($y, $m, $d)
    {
        $greg = CalendarUtils::toGregorian($y, $m, $d);
        if (Carbon::create($greg[0], $greg[1], $greg[2])->dayOfWeek == 5)
            return ['is_holiday' => true, 'cause' => 'جمعه'];

        return self::crawl($y, $m ,$d);
    }

    /**
     * @param int|Carbon $y
     * @param int|null $m
     * @param int|null $d
     * @return array
     */
    public static function gregorian($y, $m = null, $d = null)
    {
        if ($m == null) {
            $m = $y->month;
            $d = $y->day;
            $y = $y->year;
        }

        if (Carbon::create($y, $m, $d)->dayOfWeek == 5)
            return ['is_holiday' => true, 'cause' => 'جمعه'];

        $ymd = CalendarUtils::toJalali($y, $m, $d);
        return self::crawl($ymd[0], $ymd[1], $ymd[2]);
    }
}